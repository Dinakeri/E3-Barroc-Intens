import Chart, { Filler } from "chart.js/auto";
import { color } from "chart.js/helpers";

const monthLabels = [
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
];

const chartDefinitions = [
    {
        id: "totalOrdersChart",
        config: {
            type: "line",
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: "Total Orders",
                        data: [
                            120, 150, 180, 200, 220, 250, 300, 320, 350, 400, 450,
                            500,
                        ],
                        borderColor: "#2563eb",
                        backgroundColor: "rgba(37, 99, 235, 0.1)",
                        tension: 0.4,
                    },
                ],
            },
        },
    },
    {
        id: "totalCustomersChart",
        config: {
            type: "line",
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: "Total Customers",
                        data: [
                            80, 100, 130, 160, 190, 220, 250, 280, 310, 340, 370,
                            400,
                        ],
                        borderColor: "#16a34a",
                        backgroundColor: "rgba(22, 163, 74, 0.1)",
                        tension: 0.4,
                    },
                ],
            },
        },
    },
    {
        id: "totalInstallationsLineChart",
        config: {
            type: "line",
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: "Installaties",
                        data: [
                            12, 22, 31, 18, 25, 28, 33, 26, 30, 21, 19, 24,
                        ],
                        backgroundColor: "rgba(37, 99, 235, 0.6)",
                        borderColor: "#2563eb",
                        tension: 0.4,
                        fill: false,                        
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        },
    },
    {
        id: "totalMaintenancesLineChart",
        config: {
            type: "line",
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: "Onderhoud",
                        data: [
                            32, 44, 12, 14, 25, 22, 8, 16, 10, 28, 18, 6,
                        ],
                        backgroundColor: "rgba(22, 163, 74, 0.6)",
                        borderColor: "#16a34a",
                        tension: 0.4,
                        fill: false,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        },
    },
    {
        id: "totalIncidentsLineChart",
        config: {
            type: "line",
            data: {
                labels: monthLabels,
                datasets: [
                    {
                        label: "Storingen",
                        data: [
                            5, 9, 4, 7, 6, 5, 3, 8, 6, 7, 5, 4,
                        ],
                        borderColor: "#ef4444",
                        backgroundColor: "rgba(239, 68, 68, 0.6)",
                        tension: 0.4,
                        fill: false,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        },
    },
];

chartDefinitions.forEach(({ id, config }) => {
    const canvasElement = document.getElementById(id);

    if (!canvasElement) {
        return;
    }

    new Chart(canvasElement, config);
});
