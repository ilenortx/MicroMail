mui.ready(function() {
	page.searchLs(); //初始化搜索列表
	$('.search-input').on('keypress', function(event) {
		if(event.keyCode === 13) {
			page.search($(this).val());
		}
	});

	$(".search-input").focus(function() {
		$('.history-div').show(); $('.search-result-div').hide();
	});
});

var page = {
	data: {

	},

	search: function(val) { //搜索事件
		if(val) {
			var ls = app.ls.get("search") || "";
			if(ls.indexOf(val) == -1) {
				app.ls.save("search", ls + val + ",");
				this.searchLs();
			}

			this.searchPros(val);

			$('.history-div').hide(); $('.search-result-div').show();
		}
	},
	searchPros: function(code) {
		var proList = $('.pro-list-div'); proList.html('');
		$(".search-input").blur();
		mui.post(app.d.hostUrl + '/ApiSearch/index', {
			code: code,
			shop_id: 1
		}, function(data) {
			var data = app.json.decode(data);
			if(data.status == 1) {
				var pros = data.pros;
				if(pros.length) {
					$('.search-null-div').hide(); $('.pro-list-div').show();
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
					for(var i = 0; i < pros.length; ++i) {
						proList.append(cdom(pros[i]));
					}
				}
			} else {

			}
		});
	},
	searchLs: function() { //搜索历史
		var ls = app.ls.get("search");
		var lsItems = $('.ls-items');
		lsItems.html('');
		if(ls) {
			ls = this.removeEmptyArrayEle(ls.split(',').reverse());
			for(var i = 0; i < ls.length; ++i) {
				var li = $('<li onclick="lsSearch(\'' + ls[i] + '\');">' + ls[i] + '</li>');
				lsItems.append(li);
			}
		}
	},

	removeEmptyArrayEle: function(arr) {
		for(var i = 0; i < arr.length; i++) {
			if(!arr[i] || arr[i] == undefined) {
				arr.splice(i, 1);
				i = i - 1;
			}
		}
		return arr;
	},

}

function lsSearch(str) {
	page.searchPros(str);
	$('.search-input').val(str);
	$('.history-div').hide();
	$('.search-result-div').show();
}
function clearLs(){
	app.ls.save("search", "");
	page.searchLs();
}
