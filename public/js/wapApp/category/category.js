mui.ready(function() {
	page.initWinWH();
	$('.classify').css({
		'height': page.data.winHeight - 90
	});

	page.cgInit();

});

var page = {
	data: {
		winWidth: 0,
		winHeight: 0,
		cgarr: [],
		childs: [],
		cgid: 0,
		currentTab: 0,
	},

	initWinWH: function() {
		this.data.winWidth = $(window).width();
		this.data.winHeight = $(window).height();
	},

	cgInit: function() {
		var _this = this;
		var hi = app.d.hostImg;

		function cnode(obj, index) {
			var lcgi = '';
			if(_this.data.currentTab == index) {
				$('.cgname').text(obj.name);
				lcgi = $('<div onclick="cgleftTap(this,' + index + ',' + obj.id + ')" class="left-cgitem active">' + obj.name + '</div>');
			} else lcgi = $('<div onclick="cgleftTap(this,' + index + ',' + obj.id + ')" class="left-cgitem">' + obj.name + '</div>');
			$('.left-div').append(lcgi);
		}

		function cnodec(obj) {
			var rc = $('<a href="../WPages/categoryProsPages?cgid='+obj.id+'" class="right-cgitem"></a>');
			var img = $('<img src="' + hi + obj.bz_1 + '" />');
			var text = $('<text>' + obj.name + '</text>');
			rc.append(img);
			rc.append(text);
			$('.right-items').append(rc);
		}
		mui.post(app.d.hostUrl + 'ApiCategory/cgInit', {}, function(data) {
			var data = app.json.decode(data);
			var cgarr = data.cgarr;
			var childs = Array();

			if(cgarr.length > 0) {
				childs = cgarr[0].childs
				_this.data.childs = cgarr[0].childs;
				_this.data.cgid = cgarr[0].id;
			}

			_this.data.cgarr = cgarr;

			for(var i in cgarr) {
				cnode(cgarr[i], i);
			}
			for(var i in childs) {
				cnodec(childs[i]);
			}
		});
	}

}

function cgleftTap(obj, index, cgid) {
	$('.cgname').text($(obj).text());
	$(".left-div").animate({
		scrollTop: (index - 7) * 40
	});
	$('.left-cgitem').removeClass('active');
	$(obj).addClass('active');

	page.data.currentTab = index;
	page.data.cgid = cgid;
	
	var hi = app.d.hostImg;
	function cnodec(obj) {
		var rc = $('<a href="../WPages/categoryProsPages?cgid='+obj.id+'" class="right-cgitem"></a>');
		var img = $('<img src="' + hi + obj.bz_1 + '" />');
		var text = $('<text>' + obj.name + '</text>');
		rc.append(img);
		rc.append(text);
		$('.right-items').append(rc);
	}
	mui.post(app.d.hostUrl + 'ApiCategory/reclassify', {
		id: cgid
	}, function(data) {
		var data = app.json.decode(data);
		var cgarr = data.cgarr;
		var childs = data.childs;

		page.data.childs = childs;
		$('.right-items').html('');
		for(var i in childs) {
			cnodec(childs[i]);
		}
	});
}
