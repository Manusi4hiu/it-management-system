<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Hash;

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

    public function randomPortGenerator()
    {
        // Generate an initial random port to display on page load.
        // The range is from the end of well-known ports (1024) to the max possible port (65535).
        $initialPort = mt_rand(1024, 65535);

        return view('tools.random-port-generator', [
            'initialPort' => $initialPort,
        ]);
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

    public function bcryptGenerator()
    {
        return view('tools.bcrypt-generator');
    }

    /**
     * Handle the bcrypt hashing request via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleBcryptHash(Request $request)
    {
        $request->validate([
            'string_to_hash' => 'required|string|max:255',
            'rounds' => 'required|integer|min:4|max:31',
        ]);

        try {
            $hashedValue = Hash::make($request->string_to_hash, [
                'rounds' => $request->rounds,
            ]);

            return response()->json(['success' => true, 'hash' => $hashedValue]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to generate hash.'], 500);
        }
    }

    /**
     * Handle the bcrypt comparison request via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleBcryptCompare(Request $request)
    {
        $request->validate([
            'string_to_compare' => 'required|string|max:255',
            'hash_to_compare' => 'required|string',
        ]);

        try {
            $isMatch = Hash::check($request->string_to_compare, $request->hash_to_compare);

            return response()->json(['success' => true, 'match' => $isMatch]);
        } catch (\Exception $e) {
            // This can happen if the hash format is invalid
            return response()->json(['success' => false, 'message' => 'Invalid hash format provided.'], 422);
        }
    }
    public function integerBaseConverter()
    {
        return view('tools.integer-base-converter');
    }
}
