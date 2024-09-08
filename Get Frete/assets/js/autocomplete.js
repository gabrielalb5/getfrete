var origem = document.getElementById("origem");
var destino = document.getElementById("destino");
var origemAutocomplete, destinoAutocomplete;

function initAutocomplete() {
  origemAutocomplete = new google.maps.places.Autocomplete(origem, {
    types: ['address'],
    componentRestrictions: { 'country': ['BR'] },
    fields: ['place_id', 'formatted_address', 'geometry']
  });

  destinoAutocomplete = new google.maps.places.Autocomplete(destino, {
    types: ['address'],
    componentRestrictions: { 'country': ['BR'] },
    fields: ['place_id', 'formatted_address', 'geometry']
  });
}