 <table class="min-w-full divide-y divide-gray-200">
     <thead class="bg-gray-50">
         <tr>
             <th scope="col"
                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 ID
             </th>
             <th scope="col"
                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Data do Abate
             </th>
             <th scope="col"
                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Quantidade
             </th>
             <th scope="col"
                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Empresa
             </th>
             <th scope="col"
                 class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                 Ações
             </th>
         </tr>
     </thead>
     <tbody class="bg-white divide-y divide-gray-200">
         @foreach ($slaughters as $slaughter)
             <tr class="hover:bg-gray-50">
                 <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                     #{{ $slaughter['id'] ?? 'N/A' }}
                 </td>
                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                     <div class="flex items-center">
                         <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                         @php
                             $date = $slaughter['date'] ?? null;
                         @endphp
                         {{ $date ? \Carbon\Carbon::parse($date)->format('d/m/Y') : 'Data não informada' }}
                     </div>
                 </td>
                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                     <div class="flex items-center">
                         <i class="fas fa-weight mr-2 text-green-500"></i>
                         @php
                             $quantity = $slaughter['slaughter_quantity'] ?? 0;
                         @endphp
                         {{ number_format($quantity, 0, ',', '.') }} unidades
                     </div>
                 </td>
                 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                     @php
                         $companyId = $slaughter['id_company'] ?? null;
                         $companyName =
                             $companyId && isset($empresasMap[$companyId])
                                 ? $empresasMap[$companyId]
                                 : 'Empresa não encontrada';
                     @endphp

                     <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
                           title="{{ $companyName }}">
                         <i class="fas fa-building mr-1"></i>
                         {{ str_pad($companyId, 2, 0, STR_PAD_LEFT) . ' - ' . $companyName }}
                     </span>
                 </td>
                 <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                     <div class="flex space-x-2">
                         @php
                             $id = $slaughter['id'] ?? null;
                         @endphp
                         @if ($id)
                             <a href="{{ route('slaughter.edit', $id) }}"
                                class="text-blue-600 hover:text-blue-900 bg-blue-100 hover:bg-blue-200 px-3 py-1 rounded-md transition-colors duration-200">
                                 <i class="fas fa-edit mr-1"></i>
                                 Editar
                             </a>
                             <form method="POST"
                                   action="{{ route('slaughter.destroy', $id) }}"
                                   class="inline"
                                   onsubmit="return confirm('Tem certeza que deseja excluir este abate?')">
                                 @csrf
                                 @method('DELETE')
                                 <button type="submit"
                                         class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 px-3 py-1 rounded-md transition-colors duration-200">
                                     <i class="fas fa-trash mr-1"></i>
                                     Excluir
                                 </button>
                             </form>
                         @else
                             <span class="text-gray-400">Ações indisponíveis</span>
                         @endif
                     </div>
                 </td>
             </tr>
         @endforeach
     </tbody>
 </table>
