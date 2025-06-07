<script>
    // Função para atualizar os dados
    async function refreshData() {
        const refreshBtn = document.getElementById('refreshBtn');
        const refreshIcon = document.getElementById('refreshIcon');

        // Adicionar estado de loading
        refreshBtn.disabled = true;
        refreshIcon.classList.add('fa-spin');
        refreshBtn.innerHTML = '<i class="fas fa-sync-alt fa-spin mr-2"></i>Atualizando...';

        try {
            const response = await fetch('{{ route('feed-consumption.api.index') }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Atualizar a tabela com os novos dados
                updateTable(data.data);

                // Mostrar mensagem de sucesso
                showAlert('Dados atualizados com sucesso!', 'success');
            } else {
                showAlert('Erro ao atualizar dados: ' + data.message, 'error');
            }
        } catch (error) {
            console.error('Erro:', error);
            showAlert('Erro ao conectar com o servidor', 'error');
        } finally {
            // Remover estado de loading
            refreshBtn.disabled = false;
            refreshIcon.classList.remove('fa-spin');
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt mr-2"></i>Atualizar Dados';
        }
    }

    // Função para atualizar a tabela
    function updateTable(projections) {
        const tableBody = document.getElementById('projectionsTableBody');
        const totalConsumption = projections.reduce((sum, p) => sum + p.feed_quantity, 0);

        let html = '';
        projections.forEach(projection => {
            const percentage = totalConsumption > 0 ? (projection.feed_quantity / totalConsumption) * 100 : 0;
            const consumptionKg = projection.feed_quantity / 1000;

            let statusBadge = '';
            if (consumptionKg < 0.5) {
                statusBadge =
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"><i class="fas fa-exclamation-triangle mr-1"></i> Baixo</span>';
            } else if (consumptionKg >= 0.5 && consumptionKg < 1) {
                statusBadge =
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"><i class="fas fa-check-circle mr-1"></i> Normal</span>';
            } else {
                statusBadge =
                    '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"><i class="fas fa-arrow-up mr-1"></i> Alto</span>';
            }

            html += `
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-blue-600">${projection.week}</span>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">Semana ${projection.week}</div>
                            <div class="text-sm text-gray-500">${projection.week}ª semana do ciclo</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm text-gray-900">${projection.feed_quantity.toLocaleString('pt-BR')} g</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900">${consumptionKg.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2})} kg</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-16 bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: ${percentage}%"></div>
                        </div>
                        <span class="ml-2 text-sm text-gray-600">${percentage.toLocaleString('pt-BR', {minimumFractionDigits: 1, maximumFractionDigits: 1})}%</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    ${statusBadge}
                </td>
            </tr>
        `;
        });

        tableBody.innerHTML = html;
    }

    // Função para mostrar alertas
    function showAlert(message, type) {
        // Remove alertas existentes
        const existingAlerts = document.querySelectorAll('.alert-dynamic');
        existingAlerts.forEach(alert => alert.remove());

        const alertClass = type === 'success' ? 'bg-green-50 border-green-200 text-green-700' :
            'bg-red-50 border-red-200 text-red-700';
        const iconClass = type === 'success' ? 'fas fa-check-circle text-green-400' :
            'fas fa-exclamation-circle text-red-400';

        const alertHtml = `
        <div class="alert-dynamic mb-6 ${alertClass} border rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="${iconClass}"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm">${message}</p>
                </div>
            </div>
        </div>
    `;

        // Inserir o alerta após o título
        const titleSection = document.querySelector('.mb-8');
        titleSection.insertAdjacentHTML('afterend', alertHtml);

        // Remover o alerta após 5 segundos
        setTimeout(() => {
            const alert = document.querySelector('.alert-dynamic');
            if (alert) {
                alert.remove();
            }
        }, 5000);
    }
</script>
