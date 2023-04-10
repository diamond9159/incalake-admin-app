	CKEDITOR.addTemplates( 'default', {
	  imagesPath : CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	  templates :
	  [
	    {
	      title: 'Alert Danger',
	      image: 'template1.gif',
	      description: 'Esta plantilla se puede usar para las notificaciones.',
	      html:
	        '<div class="alert alert-danger">'+
	        	'<h3>Titulo de la Alerta</h3>'+
	        	'<p class="text-justify">Contenido/descripción de la Alerta.</p>'+
	        '</div>'
	    },
	    {
	      title: 'Alert Success',
	      image: 'template2.gif',
	      description: 'Esta plantilla se puede usar para las alertas.',
	      html:
	      '<h3>Plantilla 2</h3>' +
	      '<p>Inserte el texto aqu&iacute;.</p>'
	    },
	    {
	      title: 'Alert Warning',
	      image: 'template3.gif',
	      description: 'Esta plantilla se puede usar para algunas notificaciones y alertas.',
	      html:
	      '<h3>Plantilla 2</h3>' +
	      '<p>Inserte el texto aqu&iacute;.</p>'
	    },
	    {
	      title: 'Alert Info',
	      image: 'template4.gif',
	      description: 'Esta plantilla se puede usar para mostrar informacion relevante.',
	      html:
	      '<h3>Plantilla 2</h3>' +
	      '<p>Inserte el texto aqu&iacute;.</p>'
	    }
	  ]
	});