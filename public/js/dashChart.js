var bookingData = {
    labels: _lables,
    datasets: [
        {
            label: "Bookings Overview",
            data: _data,
            fill: false,
            borderColor: "rgb(75, 192, 192)",
            tension: 0.4,
        },
    ],
};

var bookingChart = new Chart(document.getElementById("booking-chart"), {
    type: "line",
    data: bookingData,
    options: {
        responsive: false,
        maintainAspectRatio: true,
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: "Check In Date",
                    font: {
                        weight: "bold",
                        size: 16,
                        family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    },
                },
                ticks: {
                    font: {
                        size: 14,
                        family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    },
                },
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: "Number of Bookings",
                    font: {
                        weight: "bold",
                        size: 16,
                        family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    },
                },
                ticks: {
                    font: {
                        size: 14,
                        family: "'Helvetica Neue', 'Helvetica', 'Arial', sans-serif",
                    },
                },
            },
        },
    },
});
