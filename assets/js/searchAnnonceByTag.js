const searchByTagSelector = document.querySelector('[name = search_by_tags]');
// console.log('selector is ', searchByTagSelector);

searchByTagSelector.addEventListener('change', (e)=> {
    document.location = `/annonce-by-tag/${event.target.value}`;
});