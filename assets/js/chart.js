/**
 * Chart.js Implementation for Movie Rating & Review System
 * Creates static charts for rating and genre distribution (NO ANIMATIONS)
 * 
 * @author Senior PHP Developer
 * @date December 18, 2025
 */

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    
    // Get the modal element
    const chartsModal = document.getElementById('chartsModal');
    
    if (chartsModal) {
        // Create charts only when modal is shown (so they render at correct size)
        let chartsCreated = false;
        
        chartsModal.addEventListener('shown.bs.modal', function () {
            // Only create charts once
            if (!chartsCreated) {
                // Check if chart data exists (passed from index.php)
                if (typeof ratingLabels !== 'undefined' && typeof ratingCounts !== 'undefined') {
                    createRatingChart();
                }
                
                if (typeof genreLabels !== 'undefined' && typeof genreCounts !== 'undefined') {
                    createGenreChart();
                }
                
                chartsCreated = true;
            }
        });
    }
});

/**
 * Create Rating Distribution Chart (Bar Chart)
 * Shows number of movies for each rating (1-5)
 * COMPLETELY STATIC - NO ANIMATIONS
 */
function createRatingChart() {
    const ctx = document.getElementById('ratingChart');
    
    if (!ctx) {
        console.warn('Rating chart canvas not found');
        return;
    }
    
    // Prepare data - ensure all ratings from 1-5 are present
    const fullRatingData = [0, 0, 0, 0, 0]; // Initialize for ratings 1-5
    
    ratingLabels.forEach((rating, index) => {
        fullRatingData[rating - 1] = ratingCounts[index];
    });
    
    // Create gradient for bars
    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(255, 193, 7, 0.8)');
    gradient.addColorStop(1, 'rgba(255, 87, 34, 0.8)');
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
            datasets: [{
                label: 'Number of Movies',
                data: fullRatingData,
                backgroundColor: gradient,
                borderColor: 'rgba(255, 193, 7, 1)',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            animation: false,
            animations: {
                colors: false,
                x: false,
                y: false
            },
            transitions: {
                active: {
                    animation: {
                        duration: 0
                    }
                }
            },
            events: [],
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        color: '#333',
                        padding: 15
                    }
                },
                title: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        color: '#666',
                        font: {
                            size: 12
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#666',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            }
        }
    });
}

/**
 * Create Genre Distribution Chart (Doughnut Chart)
 * Shows distribution of movies across different genres
 * COMPLETELY STATIC - NO ANIMATIONS
 */
function createGenreChart() {
    const ctx = document.getElementById('genreChart');
    
    if (!ctx) {
        console.warn('Genre chart canvas not found');
        return;
    }
    
    // Color palette for genres
    const colorPalette = [
        'rgba(255, 99, 132, 0.8)',   // Red
        'rgba(54, 162, 235, 0.8)',   // Blue
        'rgba(255, 206, 86, 0.8)',   // Yellow
        'rgba(75, 192, 192, 0.8)',   // Teal
        'rgba(153, 102, 255, 0.8)',  // Purple
        'rgba(255, 159, 64, 0.8)',   // Orange
        'rgba(199, 199, 199, 0.8)',  // Grey
        'rgba(83, 102, 255, 0.8)',   // Indigo
        'rgba(255, 99, 255, 0.8)',   // Pink
        'rgba(99, 255, 132, 0.8)',   // Green
        'rgba(255, 206, 199, 0.8)',  // Salmon
        'rgba(132, 99, 255, 0.8)'    // Violet
    ];
    
    const borderColors = colorPalette.map(color => color.replace('0.8', '1'));
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: genreLabels,
            datasets: [{
                label: 'Number of Movies',
                data: genreCounts,
                backgroundColor: colorPalette.slice(0, genreLabels.length),
                borderColor: borderColors.slice(0, genreLabels.length),
                borderWidth: 2
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            animation: false,
            animations: {
                colors: false,
                x: false,
                y: false
            },
            transitions: {
                active: {
                    animation: {
                        duration: 0
                    }
                }
            },
            events: [],
            plugins: {
                legend: {
                    display: true,
                    position: 'right',
                    labels: {
                        font: {
                            size: 12
                        },
                        color: '#333',
                        padding: 10,
                        boxWidth: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                title: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            },
            cutout: '60%'
        }
    });
}

// Export functions for use in other scripts if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        createRatingChart,
        createGenreChart
    };
}
