$('.mydatatableEtu').DataTable({
	 columnDefs: [
        {
            searchPanes: {
                show: true,
            },
            targets: [0,1,2,3]
        },
        {
            searchPanes: {
                show: false
            },
            targets: [0]
        }
    ],
    scrollY:500,
    scrollX:true,
    scrollCollapse: true,
    paging: false,
    order: [[5, 'asc']],
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    displayLength: 10,
	"oLanguage": {
		"sProcessing": "Traitement en cours...",
		"sSearch": "",
		"sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
		"sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
		"sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
		"sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
		"sInfoPostFix": "",
		"sLoadingRecords": "Chargement en cours...",
		"sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
		"sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau"
	},
	language: {
		searchPanes: {
			clearMessage: 'Retirer les filtres',
			showMessage: 'Afficher les filtres',
			collapseMessage: 'Réduire',
			collapse: {
				0: 'Filtrer', _: 'Filtrer (%d)'
			},
			title: {
	            _: ' %d filtres sélectionnés',
	            0: 'Aucun filtre sélectionné',
	            1: '1 filtre sélectionné'
			}
		}
	},
	buttons: [
    	'searchPanes'
    ],
    dom: 'Bfrtip'
});