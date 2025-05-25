@php
// use App\Helpers\IdEncryptor;
    // $encryptedId = IdEncryptor::encode($danger->id);
@endphp

<script>
console.log('Js Présent');

$(function() {
    // Vérifier si l'appareil est mobile
    const isMobile = window.innerWidth < 768;

    // Nouveau : appel global
    let dangerChart = null; // Pour gérer la destruction du graphique précédent

    // Appel AJAX pour récupérer les données globales
    $.ajax({
        url: `/product/dangers/all`,
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log('Données reçues:', data); // Debug

            if (data.length >= 3) {
                $('#graphRow').show();
                $('#dangersList').hide();
                renderDangerChart(data);
            } else {
                $('#dangersList').show();
                $('#graphRow').hide();
                renderDangersList(data);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors de la récupération des données:', error);
            $('<div class="alert alert-danger mt-3">Erreur lors du chargement des données</div>')
                .insertAfter('#graphRow');
        }
    });

    function renderDangersList(data) {
        const tableBody = $('#dangersListBody');
        tableBody.empty();

        data.sort((a, b) => b.count - a.count);

        data.forEach(item => {
            const row = $('<tr>');
            const dangerCell = $('<td>').text(item.nomdanger);
            const countCell = $('<td class="text-center">').text(item.count);

            if (item.products && item.products.length > 0) {
                row.attr('title', 'Produits: ' + item.products.join(', '));
                row.addClass('has-tooltip');

                // Détruire tout tooltip existant avant de le réinitialiser
                row.tooltip('dispose').tooltip({
                    placement: 'top',
                    html: true,
                    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner text-start" style="max-width: 300px;"></div></div>',
                    title: function() {
                        return `<strong>Produits concernés:</strong><br>${item.products.map(p => `- ${p}`).join('<br>')}`;
                    }
                });
            }

            row.append(dangerCell, countCell);
            tableBody.append(row);
        });
    }

    function renderDangerChart(data) {
        const labels = data.map(item => item.nomdanger);
        const counts = data.map(item => item.count);
        const backgroundColors = generateColors(data.length, 0.6);
        const borderColors = generateColors(data.length, 1);

        const chartData = {
            labels: isMobile ? labels.map(abbreviateLabel) : labels,
            datasets: [{
                label: 'Nombre de produits',
                data: counts,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 1
            }]
        };

        const options = {
            responsive: true,
            maintainAspectRatio: !isMobile,
            layout: {
                padding: 30
            },
            cutout: '45%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        title: ctx => labels[ctx[0].dataIndex],
                        label: ctx => {
                            const danger = data[ctx.dataIndex];
                            let result = [`Total: ${danger.count} produit(s)`];
                            if (danger.products?.length) {
                                // result.push('', 'Produits concernés:');
                                // result.push(...danger.products.map(p => `- ${p}`));
                            }
                            return result;
                        }
                    }
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false
                }
            },
       


        // **Nouvelle option onClick ici **
        onClick: (evt, activeEls) => {
            if (activeEls.length > 0) {
                // index du segment cliqué
                const idx = activeEls[0].index;
                // danger cliqué
                const danger = data[idx];

                // par exemple, on construit une URL vers /product/dangers/{nomdanger}
                // const safeName = encodeURIComponent(danger.nomdanger);
                const url = `/dangers/product/${danger.encrypted_id}`;

                // ouvre dans la même fenêtre
                window.location.href = url;

                // ou pour nouvelle fenêtre :
                // window.open(url, '_blank');
            }
        }
    };


        // Détruire le graphique précédent
        if (dangerChart) {
            dangerChart.destroy();
        }

        const ctx = document.getElementById('dangerChart').getContext('2d');
        dangerChart = new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: options
        });

        generateCustomLegend(labels, backgroundColors);
    }

    function abbreviateLabel(label) {
        return isMobile && label.length > 10 ? label.slice(0, 7) + '...' : label;
    }

    function generateColors(count, alpha) {
        const hueStep = 360 / count;
        return Array.from({
            length: count
        }, (_, i) => `hsla(${i * hueStep}, 70%, 60%, ${alpha})`);
    }

    function generateCustomLegend(labels, colors) {
        const legendContainer = document.getElementById('customLegend');
        legendContainer.innerHTML = '<h5 class="legend-title">Légende</h5>';
        if (isMobile) legendContainer.classList.add('legend-container-mobile');

        labels.forEach((label, i) => {
            const item = document.createElement('div');
            item.className = 'legend-item';

            const colorBox = document.createElement('div');
            colorBox.className = 'legend-color';
            colorBox.style.backgroundColor = colors[i];

            const labelText = document.createElement('span');
            labelText.className = 'legend-text';
            labelText.textContent = label;

            item.append(colorBox, labelText);
            legendContainer.appendChild(item);
        });
    }
});
</script>