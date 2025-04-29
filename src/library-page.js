// activate list items
function activateItem(item) {
    const listItems = document.querySelectorAll('.list-item');
    listItems.forEach(li => li.classList.remove('active', 'translate-x-5', 'font-bold', 'text-black', 'bg-gray-100'));
    item.classList.add('active', 'translate-x-5', 'font-bold', 'text-black', 'bg-gray-100');
}



// document.addEventListener('DOMContentLoaded', function () {
//     const libraryItem = document.querySelector('.list-item.active');
//     activateItem(libraryItem); 
//     toggleCategoryDetails('details');
// });




// catagory logol
// Automatically activate the "Library" item on page load
document.addEventListener('DOMContentLoaded', function () {
    const libraryItem = document.getElementById('libraryItem');
    activateItem(libraryItem); 
    toggleCategoryDetails('details'); 
});

// visible section
function toggleCategoryDetails(category) {
    //hide all section
    const sections = document.querySelectorAll('[id^="catagory"]');
    
    sections.forEach(section => {
        if (section.id !== 'libraryItem') { 
            section.classList.add('hidden');
        }
    });

    // Show section
    const selectedSection = document.getElementById(`catagory${category}`);
    if (selectedSection) {
        selectedSection.classList.remove('hidden');
    }
}


//  Function to activate add items


    function addsection(clickedItem) {
        // Remove the 'active' class from all list items
        const allItems = document.querySelectorAll('.Add_items');
        allItems.forEach(item => item.classList.remove('active','font-bold', 'text-black'));
       

        // Add the 'active' class to the clicked list item
        clickedItem.classList.add('active','font-bold', 'text-black');
        
    }



// for searchbar

// Array to store previous searches
// let previousSearches = [];

// // Get references to the search bar and suggestions container
// const searchBar = document.getElementById('Titlebooks');
// const suggestionsContainer = document.getElementById('suggestions');
// const titleArrow = document.getElementById('titleArrow');
// const forsearch = document.getElementById('forsearch');

// // Function to display suggestions
// const showSuggestions = () => {
//     if (previousSearches.length === 0) {
//         suggestionsContainer.classList.add('hidden');
//         titleArrow.style.transform = 'rotate(0deg)';
//         return;
//     }

//     // Filter searches that match the current input
//     const inputValue = searchBar.value.toLowerCase();
//     const filteredSuggestions = previousSearches.filter((search) =>
//         search.toLowerCase().includes(inputValue)
//     );

//     // Clear previous suggestions
//     suggestionsContainer.innerHTML = '';

//     // Add new suggestions
//     filteredSuggestions.forEach((suggestion) => {
//         const suggestionItem = document.createElement('div');
//         suggestionItem.textContent = suggestion;
//         suggestionItem.classList.add(' text-lg','px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
//         suggestionItem.addEventListener('click', () => {
//             searchBar.value = suggestion;
//             suggestionsContainer.classList.add('hidden');
//             titleArrow.style.transform = 'rotate(0deg)';
//         });
//         suggestionsContainer.appendChild(suggestionItem);
//     });

//     // Show or hide the suggestions container
//     if (filteredSuggestions.length > 0) {
//         suggestionsContainer.classList.remove('hidden');
//         titleArrow.style.transform = 'rotate(90deg)';
//     } else {
//         suggestionsContainer.classList.add('hidden');
//         titleArrow.style.transform = 'rotate(0deg)';
//     }
// };

// // Function to save a search to the previous searches array
// const saveSearch = (search) => {
//     if (!previousSearches.includes(search)) {
//         previousSearches.push(search);
//     }
// };

// // Event listener for input changes
// searchBar.addEventListener('input', showSuggestions);

// forsearch.addEventListener('click', (event) => {
//     const searchValue = searchBar.value.trim();

//     if (searchValue) {
//         saveSearch(searchValue);
//         forsearch.value = '';
//         suggestionsContainer.classList.add('hidden');
       
//     }

// })

// // Event listener for form submission (e.g., pressing Enter)
// searchBar.addEventListener('keydown', (event) => {
//     if (event.key === 'Enter') {
//         const searchValue = searchBar.value.trim();
//         if (searchValue) {
//             saveSearch(searchValue);
//             searchBar.value = '';
//             suggestionsContainer.classList.add('hidden');
//             titleArrow.style.transform = 'rotate(0deg)';
//         }
//     }
// });

// // Hide suggestions when clicking outside
// document.addEventListener('click', (event) => {
//     if (!searchBar.contains(event.target) && !suggestionsContainer.contains(event.target)) {
//         suggestionsContainer.classList.add('hidden');
//         titleArrow.style.transform = 'rotate(0deg)';
//     }
// });



// // for alphabate

// document.addEventListener('DOMContentLoaded', function () {
//     const alphabetContainer = document.getElementById('letter');

//     // Loop through A-Z (ASCII codes 65 to 90)
//     for (let i = 65; i <= 90; i++) {
//         const letter = String.fromCharCode(i); // Convert ASCII code to letter
//         const letterDiv = document.createElement('div');

//         // Add Tailwind CSS classes for styling
//         letterDiv.className =
//             ' flex items-center justify-center w-[1000px] h-[41px] text-black gap-2 font-bold cursor-pointer';

//         // Set the letter as the content
//         letterDiv.textContent = letter;

//         // Append the letter to the container
//         alphabetContainer.appendChild(letterDiv);
//     }
// });

