// Function to create a new chart (graph)
function createChart(sensor_name, chartData, color) {
  // Get the canvas element by ID
  var canvas = document.getElementById("Chart_" + sensor_name);

  // reverse the array to have data classified in the right order
  var data = chartData[sensor_name].reverse();
  // keep the last 10 values only
  data = data.slice(-10);
  
    // Generate a random color (generate a random number between 0 and 16777215 and convert it to hexa)
  var randomColor = '#' + Math.floor(Math.random() * 16777215).toString(16);

  // specify each characteristic of our chart for chart.js to make
  var chart = new Chart(canvas, {
    type: 'line',
    data: {
      // Labels are the name of each point of the graph
      labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
      datasets: [
        {
          label: "évolution des 10 dernières valeurs",
          pointRadius: 10,
          pointHoverRadius: 15,
          // Specify which data to use for the graph
          data: data,
          borderColor: randomColor,
          borderWidth: 2
        }
      ]
    }
  });
}