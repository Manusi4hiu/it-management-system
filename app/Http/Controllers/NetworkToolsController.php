<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class NetworkToolsController extends Controller
{
    public function ping(): View
    {
        return view('tools.ping');
    }

    public function executePing(Request $request): JsonResponse
    {
        $request->validate([
            'host' => 'required|string|max:255',
            'count' => 'nullable|integer|min:1|max:10'
        ]);

        $host = $request->input('host');
        $count = $request->input('count', 4);

        try {
            // Untuk Windows dan Linux
            $command = PHP_OS_FAMILY === 'Windows'
                ? ['ping', '-n', $count, $host]
                : ['ping', '-c', $count, $host];

            $process = new Process($command);
            $process->setTimeout(30);
            $process->run();

            return response()->json([
                'success' => true,
                'output' => $process->getOutput(),
                'error' => $process->getErrorOutput()
            ]);
        } catch (ProcessFailedException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to execute ping command: ' . $e->getMessage()
            ]);
        }
    }

    public function traceroute(): View
    {
        return view('tools.traceroute');
    }

    public function executeTraceroute(Request $request): JsonResponse
    {
        $request->validate([
            'host' => 'required|string|max:255',
            'max_hops' => 'nullable|integer|min:1|max:30'
        ]);

        $host = $request->input('host');
        $maxHops = $request->input('max_hops', 15);

        try {
            $command = PHP_OS_FAMILY === 'Windows'
                ? ['tracert', '-h', $maxHops, $host]
                : ['traceroute', '-m', $maxHops, $host];

            $process = new Process($command);
            $process->setTimeout(60);
            $process->run();

            return response()->json([
                'success' => true,
                'output' => $process->getOutput(),
                'error' => $process->getErrorOutput()
            ]);
        } catch (ProcessFailedException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to execute traceroute command: ' . $e->getMessage()
            ]);
        }
    }

    public function portScanner(): View
    {
        return view('tools.port-scanner');
    }

    public function executePortScan(Request $request): JsonResponse
    {
        $request->validate([
            'host' => 'required|string|max:255',
            'ports' => 'required|string|max:255',
            'timeout' => 'nullable|integer|min:1|max:10'
        ]);

        $host = $request->input('host');
        $ports = $request->input('ports');
        $timeout = $request->input('timeout', 3);

        $results = [];
        $portList = $this->parsePortRange($ports);

        foreach ($portList as $port) {
            $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);

            if ($connection) {
                $results[] = [
                    'port' => $port,
                    'status' => 'open',
                    'service' => $this->getServiceName($port)
                ];
                fclose($connection);
            } else {
                $results[] = [
                    'port' => $port,
                    'status' => 'closed',
                    'service' => $this->getServiceName($port)
                ];
            }
        }

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }

    public function whois(): View
    {
        return view('tools.whois');
    }

    public function executeWhois(Request $request): JsonResponse
    {
        $request->validate([
            'domain' => 'required|string|max:255'
        ]);

        $domain = $request->input('domain');

        try {
            $command = ['whois', $domain];
            $process = new Process($command);
            $process->setTimeout(30);
            $process->run();

            return response()->json([
                'success' => true,
                'output' => $process->getOutput(),
                'error' => $process->getErrorOutput()
            ]);
        } catch (ProcessFailedException $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to execute whois command: ' . $e->getMessage()
            ]);
        }
    }

    private function parsePortRange(string $ports): array
    {
        $portList = [];
        $parts = explode(',', $ports);

        foreach ($parts as $part) {
            $part = trim($part);

            if (strpos($part, '-') !== false) {
                [$start, $end] = explode('-', $part);
                $start = (int) trim($start);
                $end = (int) trim($end);

                for ($i = $start; $i <= $end && $i <= 65535; $i++) {
                    $portList[] = $i;
                }
            } else {
                $port = (int) $part;
                if ($port > 0 && $port <= 65535) {
                    $portList[] = $port;
                }
            }
        }

        return array_unique($portList);
    }

    private function getServiceName(int $port): string
    {
        $services = [
            21 => 'FTP',
            22 => 'SSH',
            23 => 'Telnet',
            25 => 'SMTP',
            53 => 'DNS',
            80 => 'HTTP',
            110 => 'POP3',
            143 => 'IMAP',
            443 => 'HTTPS',
            993 => 'IMAPS',
            995 => 'POP3S',
            3389 => 'RDP',
            5432 => 'PostgreSQL',
            3306 => 'MySQL'
        ];

        return $services[$port] ?? 'Unknown';
    }
}
