const totaLOrdersChart = document.getElementById("totalOrdersChart");
const totalCustomersChart = document.getElementById("totalCustomersChart");

new Chart(totaLOrdersChart, {
    type: "line",
    data: {
        labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sept",
            "Oct",
            "Nov",
            "Dec",
        ],
        datasets: [
            {
                label: "Total Orders",
                data: [
                    120, 150, 180, 200, 220, 250, 300, 320, 350, 400, 450, 500,
                ],
                tension: 0.4,
            },
        ],
    },
});

new Chart(totalCustomersChart, {
    type: "line",
    data: {
        labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sept",
            "Oct",
            "Nov",
            "Dec",
        ],
        datasets: [
            {
                label: "Total Customers",
                data: [
                    80, 100, 130, 160, 190, 220, 250, 280, 310, 340, 370, 400,
                ],
                tension: 0.4,
            },
        ],
    },
});
