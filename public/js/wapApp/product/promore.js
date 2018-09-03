mui.ready(function() {
	page.loadPros();

//	$(window).scroll(function() {　　
//		var scrollTop = $(this).scrollTop();　　
//		var scrollHeight = $(document).height();　　
//		var windowHeight = $(this).height();　　
//		if(scrollTop + windowHeight == (scrollHeight)) {
//			page.loadPros();
//		}
//	});

});

var page = {
	data: {
		cid: 0,
		offset: 0,
		px: 0,
		pros: []
	},
	loadPros: function(callback) {
		var proList = $('.pro-list-div');
		if (this.data.offset==0) proList.html('');
		var _this = this;

		mui.post(app.d.hostUrl + '/ApiIndex/promore', {
			cid: this.data.cid,
			offset: this.data.offset,
			px: this.data.px
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				for(var k in data.prolist) {
					_this.data.pros.push(data.prolist[k]);
				}
				var pros = _this.data.pros;

				if(pros.length) {
					_this.data.offset += 1;
					var width = $(window).width() * 0.46;

					function cdom(obj) {
						var proItem = $('<a href="../WPages/proDetailPage?productId=' + obj.id + '" class="pro-item"></a>');
						var img = $('<img src="' + app.d.hostImg + obj.photo_x + '" />');
						var title = $('<text class="title">' + obj.name + '</text>');
						var priceDiv = $('<div class="price-div"></div>');
						var priceYh = $('<text class="price_yh">￥' + obj.price_yh + '</text>');
						var price = $('<text class="price">￥' + obj.price + '</text>');
						priceDiv.append(priceYh);
						priceDiv.append(price);

						img.width(width);
						img.height(width);
						proItem.append(img);
						proItem.append(title);
						proItem.append(priceDiv);

						return proItem;
					}
					for(var i = 0; i < data.prolist.length; ++i) {
						proList.append(cdom(data.prolist[i]));
					}
				}
			}
			if (typeof(callback)!='undefined') callback(data.status==0 || data.prolist.length==0);
		});
	},
}

function pxquery(obj) {
	$('.px-ul li').removeClass('on');
	$(obj).addClass('on');

	var px = $(obj).attr('px');
	if(px != '2' && px != '3') {
		$('#jg-px').attr('src', '../img/wapApp/sort1.png');
		$('.price').attr('px', '3');
	} else if(px == '2') {
		$('#jg-px').attr('src', '../img/wapApp/sort3.png');
		$('.price').attr('px', '3');
	} else if(px == '3') {
		$('#jg-px').attr('src', '../img/wapApp/sort2.png');
		$('.price').attr('px', '2');
	}

	page.data.px = $(obj).attr('px');
	page.data.offset = 0;
	page.data.pros = [];
	page.loadPros();
}

function loadMore(callback){
	page.loadPros(callback);
}
