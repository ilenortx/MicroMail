mui.ready(function() {
	
	page.loadsns();

});

var page = {
	data: {
		proid: 0,
        prosns: []
	},
	
	loadsns: function(){
		var _this = this;
		mui.post(app.d.hostUrl + 'ApiProduct/prosnList', {
			proid: _this.data.proid
		}, function(data) {
			var data = app.json.decode(data);
	
			if(data.status == 1) {
				_this.data.prosns = data.prosns;
				
				for (var i in data.prosns){
					var snItem = $('<div class="sn-item"></div>');
					var sit = $('<div class="sn-info-top"></div>');
					sit.append('<img src="../img/wapApp/prosn-ok.png" />');
					sit.append('<div class="title">'+data.prosns[i].title+'</div>');
					snItem.append(sit);
					snItem.append('<div class="descript">'+data.prosns[i].descript+'</div>');
					
					$('.sn-items-div').append(snItem);
				}
			} else {
				alert(data.err);
			}
		});
	}

}
