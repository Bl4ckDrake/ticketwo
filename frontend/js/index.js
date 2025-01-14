function addConcertCard(
  title,
  description,
  imageUrl,
  lastUpdated,
  buttonText,
  buttonLink
) {
  const concertsDiv = document.getElementById("concerts");

  // Create the card structure
  const cardHTML = `
        <div class="col-sm-6 mb-3">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="${imageUrl}" class="img-fluid rounded-start" alt="${title}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">${title}</h5>
                            <p class="card-text">${description}</p>
                            <p class="card-text"><small class="text-body-secondary">${lastUpdated}</small></p>
                            <a href="${buttonLink}" class="btn btn-primary">${buttonText}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

  // Append the card to the div
  concertsDiv.innerHTML += cardHTML;
}

// Example usage: Add a few cards dynamically
addConcertCard(
  "Rock Festival",
  "Join us for an amazing rock concert with top bands performing live!",
  "https://placehold.co/200x300",
  "Last updated 3 mins ago",
  "Buy Tickets",
  "#"
);

addConcertCard(
  "Jazz Night",
  "Experience the best jazz performances in town. Don't miss out!",
  "https://placehold.co/200x300",
  "Last updated 1 hour ago",
  "Buy Tickets",
  "#"
);

// Create a new XMLHttpRequest object
const xhr = new XMLHttpRequest();

// Configure the request
xhr.open("GET", "http://localhost/concerts", true);

// Set up a callback to handle the response
xhr.onload = function () {
  if (xhr.status === 200) {
    // Parse the JSON response
    const concerts = JSON.parse(xhr.responseText);

    concerts.forEach((concert) => {
      addConcertCard(
        concert.name,
        "dada",
        "addadd",
        "dawdaw",
        "dadawa",
        "daadaw"
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
