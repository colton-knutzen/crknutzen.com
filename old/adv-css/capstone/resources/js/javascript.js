//Wrtie Socializer.js into Head Start
let script = document.createElement('script');
script.src = '/adv-css/capstone/resources/js/socializer.js';
document.getElementsByTagName('head')[0].appendChild(script);


//Social Media Share
function socializerLoad() {
  (function () {
    socializer('.socializer');
  }());
}


//Table of Contents
function tocDropdown() {
  if (document.getElementById("toc-dropdown").classList.contains("show")) {
    document.getElementById("toc-dropdown").classList.remove("show");
  } else {
    document.getElementById("toc-dropdown").classList.add("show");
  }
}


//Side Nav Hamburger
function openSideNav() {
  if (document.getElementById("inc-side-nav").classList.contains("show")) {
    document.getElementById("inc-side-nav").classList.remove("show");
    document.querySelector("main").classList.remove("blur");
  } else {
    document.getElementById("inc-side-nav").classList.add("show");
    document.querySelector("main").classList.add("blur");
  }
}

function hideSideNav() {
  if (window.innerWidth <= 940) {
    document.getElementById("inc-side-nav").classList.remove("show");
    document.querySelector("main").classList.remove("blur");
  }
}


//Side Nav Collapse
function sidenavDropdown(element) {
  let nextElement = element.nextElementSibling;
  if (nextElement.classList.contains("show")) {
    nextElement.classList.remove("show");
  } else {
    nextElement.classList.add("show");
  }
}


//Toc Generator
function tocLoad() {
// Get the table of contents container
const tocContainer = document.getElementById('toc-dropdown');

// Create an unordered list to hold the table of contents items
const tocList = document.createElement('ol');

// Set the previous level variable to h2 so that the first h3 heading is indented
let previousLevel = 'h2';

// Loop through each h2 and h3 tag and create a table of contents item for it
document.querySelectorAll('h2, h3').forEach((heading, i) => {
  // Create a unique ID for the heading if it doesn't already have one
  if (!heading.id) {
    heading.id = `heading-${i}`;
  }

  // Create a list item for the heading
  const tocItem = document.createElement('li');

  // Create a link that points to the heading's ID
  const tocLink = document.createElement('a');
  tocLink.textContent = heading.textContent;
  tocLink.href = `#${heading.id}`;

  // Add the link to the list item
  tocItem.appendChild(tocLink);


  if (heading.tagName.toLowerCase() === 'h2') {
    tocItem.classList.add('toc-h2');
  }

  // If the heading is an h3 and the previous heading was an h2, indent it under the previous h2 heading and add a class
  if (heading.tagName.toLowerCase() === 'h3') {
    tocItem.classList.add('toc-h3');
    tocList.lastChild.appendChild(tocItem);
  } else {
    // Reset the previous level variable if the heading is an h2
    previousLevel = 'h2';

    // Add the list item to the table of contents list
    tocList.appendChild(tocItem);
  }

  // Set the previous level variable to the current heading's tag name
  previousLevel = heading.tagName.toLowerCase();
});

// Add the table of contents list to the container
tocContainer.appendChild(tocList);

}
