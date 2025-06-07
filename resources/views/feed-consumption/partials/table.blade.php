            <table class="min-w-full divide-y divide-gray-200"
                   id="projectionsTable">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Semana
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Consumo (gramas)
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Consumo (kg)
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Porcentagem do Total
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200"
                       id="projectionsTableBody">
                    @foreach ($projections as $projection)
                        @php
                            $totalConsumption = collect($projections)->sum('feed_quantity');
                            $percentage =
                                $totalConsumption > 0 ? ($projection['feed_quantity'] / $totalConsumption) * 100 : 0;
                            $consumptionKg = $projection['feed_quantity'] / 1000;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                         class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-sm font-medium text-blue-600">{{ $projection['week'] }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">Semana {{ $projection['week'] }}
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $projection['week'] }}ª semana do ciclo
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ number_format($projection['feed_quantity'], 0, ',', '.') }} g</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ number_format($consumptionKg, 2, ',', '.') }} kg</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-16 bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full"
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span
                                          class="ml-2 text-sm text-gray-600">{{ number_format($percentage, 1, ',', '.') }}%</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($consumptionKg < 0.5)
                                    <span
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-exclamation-triangle mr-1"></i> Baixo
                                    </span>
                                @elseif($consumptionKg >= 0.5 && $consumptionKg < 1)
                                    <span
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i> Normal
                                    </span>
                                @else
                                    <span
                                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-arrow-up mr-1"></i> Alto
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
