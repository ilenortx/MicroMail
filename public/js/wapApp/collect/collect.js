mui.ready(function() {
	page.loadPros();

	$(window).scroll(function() {　　
		var scrollTop = $(this).scrollTop();　　
		var scrollHeight = $(document).height();　　
		var windowHeight = $(this).height();　　
		if(scrollTop + windowHeight == (scrollHeight)) {
			page.loadPros();
		}
	});

});

var page = {
	data: {
		uid: 0,
        offset: 0,
        cols: []
	},
	loadPros: function() {
		var proList = $('.pro-list-div');
		var _this = this;

		mui.post(app.d.hostUrl + 'ApiProduct/getColLists', {
			uid: app.ls.get("uid"), offset: _this.data.offset
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				var cols = data.cols;
				for(var k in cols) {
					_this.data.cols.push(cols[k]);
				}

				if(cols.length) {
					_this.data.offset += 1;
					// var width = $(window).width() * 0.46;

					function cdom(obj) {
						var proItem = $('<a href="../WPages/proDetailPage?productId=' + obj.id + '" class="pro-item"></a>');
						var img = $('<img src="' + app.d.hostImg + obj.photo_x + '" />');
						var title = $('<text class="title">' + obj.name + '</text>');
						var priceDiv = $('<div class="price-div"></div>');
						var priceYh = $('<text class="price_yh">￥' + obj.price_yh + '</text>');
						var price = $('<text class="price">￥' + obj.price + '</text>');
						priceDiv.append(priceYh);
						priceDiv.append(price);

						// img.width(width);
						// img.height(width);
						proItem.append(img);
						proItem.append(title);
						proItem.append(priceDiv);

						return proItem;
					}
					for(var i = 0; i < cols.length; ++i) {
						proList.append(cdom(cols[i]));
					}
				}
			}
		});
	},
}