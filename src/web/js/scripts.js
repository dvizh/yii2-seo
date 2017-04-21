if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.seo = {
    init: function () {
	$('.dvizh-seo .toggle').on('click', function() {
            $($(this).attr('href')).toggle();
            return false;
	});
    },
}

dvizh.seo.init();