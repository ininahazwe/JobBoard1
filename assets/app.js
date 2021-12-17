/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';

// You can specify which plugins you need
import { Tooltip, Toast, Popover } from 'bootstrap';

// start the Stimulus application
import './bootstrap';

// Template Js
import './js/anm.min'
import './js/appear'
import './js/chart.min'
import './js/chosen.min'
import './js/Filter'
//import './js/infobox.min'
import './js/jquery'
import './js/jquery.countdown'
import './js/jquery.fancybox'
import './js/jquery.modal.min'
import './js/jquery-ui.min'
import './js/knob'
//import './js/map-script'
//import './js/maps'
import './js/markerclusterer'
import './js/mmenu'
import './js/mmenu.polyfills'
import './js/multi-step-form'
import './js/owl'
import './js/popper.min'
//import './js/respond'
import './js/select2.min'
import './js/validate'
import './js/wow'
import './js/script'

//import './js/react';

import 'datatables.net';
import 'datatables.net-bs4';
/*import Filter from "./js/Filter";

new Filter(document.querySelector('.js-filter'))*/

$(document).ready( function () {
    $('#datatable').DataTable({
        "language": {
            "sProcessing": "Traitement en cours ...",
            "sLengthMenu": "Afficher _MENU_ lignes",
            "sZeroRecords": "Aucun résultat trouvé",
            "sEmptyTable": "Aucune donnée disponible",
            "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
            "sInfoEmpty": "Aucune ligne affichée",
            "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
            "sInfoPostFix": "",
            "sSearch": "Chercher:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Chargement...",
            "oPaginate": {
                "sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
            },
            "oAria": {
                "sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
            }
        }
    });
});
