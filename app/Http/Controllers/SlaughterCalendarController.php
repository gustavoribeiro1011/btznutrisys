<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;
use App\Services\SlaughterCalendarService;
use Illuminate\Support\Facades\Log;

class SlaughterCalendarController extends Controller
{
    protected $slaughterService;
    protected $companyService;

    public function __construct(SlaughterCalendarService $slaughterService, CompanyService $companyService)
    {
        $this->slaughterService = $slaughterService;
        $this->companyService = $companyService;
    }

    /**
     * Lista todos os abates
     */
    public function index()
    {
        $empresas = $this->companyService->listarEmpresas();

        // Criar um mapeamento de ID para nome da empresa
        $empresasMap = [];
        if (is_array($empresas)) {
            foreach ($empresas as $empresa) {
                $empresasMap[$empresa['id']] = $empresa['name'];
            }
        }

        $result = $this->slaughterService->getAll();

        // Verificar se houve erro na consulta
        if (!$result['success']) {
            Log::error('Erro ao buscar abates:', ['error' => $result['message']]);
            return view('slaughter.index', [
                'slaughters' => [],
                'empresasMap' => $empresasMap,
                'error' => $result['message'],
                'nextSlaughterInfo' => ['has_next' => false, 'formatted_date' => 'Nenhum agendado']
            ]);
        }

        // Garantir que os dados são válidos
        $slaughters = $result['data'] ?? [];

        // Debug: verificar estrutura dos dados
        Log::info('Slaughters data structure:', [
            'slaughters' => $slaughters,
            'type' => gettype($slaughters),
            'is_array' => is_array($slaughters)
        ]);

        // Validar e limpar os dados
        $slaughters = $this->validateSlaughtersData($slaughters);

        // Buscar informações do próximo abate usando o service
        $nextSlaughterInfo = $this->slaughterService->getNextSlaughterInfo();

        Log::info('Companies map:', ['empresasMap' => $empresasMap]);

        return view('slaughter.index', compact('slaughters', 'empresasMap', 'nextSlaughterInfo'));
    }

    /**
     * Valida e limpa os dados de abates
     */
    private function validateSlaughtersData($data)
    {
        // Se não é array, retorna array vazio
        if (!is_array($data)) {
            Log::warning('Slaughters data is not an array:', [
                'type' => gettype($data),
                'data' => $data
            ]);
            return [];
        }

        $validSlaughters = [];

        foreach ($data as $index => $slaughter) {
            // Verificar se cada item é válido
            if (is_array($slaughter) || is_object($slaughter)) {
                // Converter objeto para array se necessário
                if (is_object($slaughter)) {
                    $slaughter = (array) $slaughter;
                }

                // Verificar se tem os campos obrigatórios
                if (isset($slaughter['id'])) {
                    $validSlaughters[] = $slaughter;
                } else {
                    Log::warning("Invalid slaughter data at index {$index}:", [
                        'data' => $slaughter
                    ]);
                }
            } else {
                Log::warning("Invalid slaughter format at index {$index}:", [
                    'type' => gettype($slaughter),
                    'data' => $slaughter
                ]);
            }
        }

        return $validSlaughters;
    }

    /**
     * Mostra o formulário de criação
     */
    public function create()
    {
        $empresas = $this->companyService->listarEmpresas();
        return view('slaughter.create', compact('empresas'));
    }

    /**
     * Armazena um novo abate
     */
    public function store(Request $request)
    {
        $data = [
            'date' => $request->date,
            'slaughter_quantity' => (int) $request->slaughter_quantity,
            'id_company' => (int) $request->id_company
        ];

        // Validação
        $errors = $this->slaughterService->validateData($data);
        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        $result = $this->slaughterService->create($data);

        if ($result['success']) {
            return redirect()->route('slaughter.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }

    /**
     * Mostra o formulário de edição
     */
    public function edit($id)
    {
        // Buscar empresas para popular o select
        $empresas = $this->companyService->listarEmpresas();

        // Como a API não tem endpoint para buscar um item específico,
        // buscamos todos e filtramos pelo ID
        $result = $this->slaughterService->getAll();

        if (!$result['success']) {
            return redirect()->route('slaughter.index')
                ->with('error', $result['message']);
        }

        $slaughters = $result['data'] ?? [];
        $slaughter = collect($slaughters)->firstWhere('id', (int) $id);

        if (!$slaughter) {
            return redirect()->route('slaughter.index')
                ->with('error', 'Abate não encontrado');
        }

        return view('slaughter.edit', compact('slaughter', 'empresas'));
    }

    /**
     * Atualiza um abate
     */
    public function update(Request $request, $id)
    {
        $data = [
            'id' => (int) $id,
            'date' => $request->date,
            'slaughter_quantity' => (int) $request->slaughter_quantity,
            'id_company' => (int) $request->id_company
        ];

        // Validação
        $errors = $this->slaughterService->validateData($data, true);
        if (!empty($errors)) {
            return redirect()->back()
                ->withErrors($errors)
                ->withInput();
        }

        $result = $this->slaughterService->update($data);

        if ($result['success']) {
            return redirect()->route('slaughter.index')
                ->with('success', $result['message']);
        }

        return redirect()->back()
            ->with('error', $result['message'])
            ->withInput();
    }

    /**
     * Remove um abate
     */
    public function destroy($id)
    {
        $result = $this->slaughterService->delete((int) $id);

        if ($result['success']) {
            return redirect()->route('slaughter.index')
                ->with('success', $result['message']);
        }

        return redirect()->route('slaughter.index')
            ->with('error', $result['message']);
    }

    /**
     * API endpoint para buscar dados via AJAX (opcional)
     */
    public function apiIndex()
    {
        $result = $this->slaughterService->getAll();
        return response()->json($result);
    }
}
