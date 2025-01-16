function addConcertCard(
  id,
  concert_name,
  band_name,
  date,
  location,
  available_tickets,
  imageUrl
) {
  const concertsDiv = document.getElementById("concerts");

  // Create the card structure
  const cardHTML = `
        <div class="col-sm-6 mb-3">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="http://localhost:8000/${imageUrl}" class="img-fluid rounded-start" alt="${concert_name}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">${concert_name}</h5>
                            <p class="card-text">${location} ${date}</p>
                            <p class="card-text"><small class="text-body-secondary">Available Tickets: ${available_tickets}</small></p>
                            <p class="card-text"><small class="text-body-secondary">${band_name}</small></p>
                            <a href="${id}" class="btn btn-primary">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

  // Append the card to the div
  concertsDiv.innerHTML += cardHTML;
}

// Create a new XMLHttpRequest object
const xhr = new XMLHttpRequest();

// Configure the request
xhr.open("GET", "http://localhost:8000/api/concerts", true);

// Set up a callback to handle the response
xhr.onload = function () {
  if (xhr.status === 200) {
    // Parse the JSON response
    const concerts = JSON.parse(xhr.responseText);

    concerts.forEach((concert) => {
      addConcertCard(
        concert.id,
        concert.concert_name,
        concert.band_name,
        concert.date,
        concert.location,
        concert.available_tickets,
        concert.imgUrl
      );
      //listItem.textContent = `${concert.name} - ${concert.date} at ${concert.location} (${concert.available_tickets} tickets left)`;
    });
  } else {
    console.error(`Error: ${xhr.status} - ${xhr.statusText}`);
  }
};

// Handle network errors
xhr.onerror = function () {
  console.error("Network error occurred.");
};

// Send the request
xhr.send();
