<script>
    $(function () {
        // Vérifier si l'appareil est mobile
        const isMobile = window.innerWidth < 768;

        // Récupérer l'ID de l'atelier depuis la page
        const idatelier = '<?php echo $atelier->id; ?>';

        // Appel AJAX pour récupérer les données
        $.ajax({
            url: '/product/dangers/' + idatelier,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Vérifier s'il y a au moins 3 dangers différents
                if (data.length >= 3) {
                    // Afficher la ligne du graphique
                    $('#graphRow').show();
                    // Rendre le graphique
                    renderDangerChart(data);
                } else {
                    // Afficher la liste des dangers si moins de 3 dangers
                    $('#dangersList').show();
                    renderDangersList(data);
                }
            },
            error: function (xhr, status, error) {
                console.error('Erreur lors de la récupération des données:', error);
                // Afficher un message d'erreur
                $('<div class="alert alert-danger mt-3">Erreur lors du chargement des données</div>').insertAfter('#graphRow');
            }
        });

        // Fonction pour afficher la liste des dangers
        function renderDangersList(data) {
            const tableBody = $('#dangersListBody');
            tableBody.empty();

            // Trier les données par nombre de produits (décroissant)
            data.sort((a, b) => b.count - a.count);

            // Créer une ligne pour chaque danger
            data.forEach(item => {
                const row = $('<tr>');
                const dangerCell = $('<td>').text(item.nomdanger);
                const countCell = $('<td class="text-center">').text(item.count);

                // Ajouter un attribut title avec la liste des produits
                if (item.products && item.products.length > 0) {
                    const productsList = item.products.join(', ');
                    row.attr('title', 'Produits: ' + productsList);

                    // Ajouter une classe pour indiquer qu'il y a une info-bulle
                    row.addClass('has-tooltip');

                    // Initialiser tooltip Bootstrap si disponible
                    if ($.fn.tooltip) {
                        row.tooltip({
                            placement: 'top',
                            html: true,
                            template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner text-start" style="max-width: 300px;"></div></div>',
                            title: function () {
                                let content = '<strong>Produits concernés:</strong>';
                                item.products.forEach(product => {
                                    content += `- ${product}<br>`;
                                });
                                return content;
                            }
                        });
                    }
                }

                row.append(dangerCell);
                row.append(countCell);
                tableBody.append(row);
            });
        }

        function renderDangerChart(data) {
            // Code du graphique identique à celui précédemment fourni
            const labels = data.map(item => item.nomdanger);
            const counts = data.map(item => item.count);
            const backgroundColors = generateColors(data.length, 0.6);
            const borderColors = generateColors(data.length, 1);

            const chartData = {
                labels: isMobile ? labels.map(label => abbreviateLabel(label)) : labels,
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
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: isMobile ? 10 : 12
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: isMobile ? 8 : 12
                            },
                            maxRotation: isMobile ? 90 : 0,
                            minRotation: isMobile ? 45 : 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            title: function (context) {
                                return labels[context[0].dataIndex];
                            },
                            label: function (context) {
                                const dataIndex = context.dataIndex;
                                const danger = data[dataIndex];

                                // Afficher le nombre total de produits
                                const result = [`Total: ${danger.count} produit(s)`];

                                // Ajouter la liste des produits
                                if (danger.products && danger.products.length > 0) {
                                    result.push('');
                                    result.push('Produits concernés:');
                                    danger.products.forEach(product => {
                                        result.push(`- ${product}`);
                                    });
                                }

                                return result;
                            }
                        }
                    }
                }
            };

            var ctx = document.getElementById('dangerChart').getContext('2d');
            var dangerChart = new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: options
            });

            // Générer la légende personnalisée
            generateCustomLegend(labels, backgroundColors);
        }

        // Fonction pour abréger les étiquettes sur mobile
        function abbreviateLabel(label) {
            if (isMobile) {
                if (label.length > 10) {
                    return label.substring(0, 7) + '...';
                }
            }
            return label;
        }

        function generateColors(count, alpha) {
            const colors = [];
            const hueStep = 360 / count;

            for (let i = 0; i < count; i++) {
                const hue = i * hueStep;
                colors.push(`hsla(${hue}, 70%, 60%, ${alpha})`);
            }

            return colors;
        }

        function generateCustomLegend(labels, colors) {
            const legendContainer = document.getElementById('customLegend');

            // Titre de la légende
            legendContainer.innerHTML = '<h5 class="legend-title">Légende</h5>';

            // Sur mobile, utiliser un affichage horizontal
            if (isMobile) {
                legendContainer.classList.add('mobile-legend');
            }

            // Créer les éléments de légende
            labels.forEach((label, index) => {
                const legendItem = document.createElement('div');
                legendItem.className = 'legend-item';

                const colorBox = document.createElement('div');
                colorBox.className = 'legend-color';
                colorBox.style.backgroundColor = colors[index];

                const labelText = document.createElement('span');
                labelText.className = 'legend-text';
                labelText.textContent = label;

                legendItem.appendChild(colorBox);
                legendItem.appendChild(labelText);
                legendContainer.appendChild(legendItem);
            });
        }
    });
</script>