mui.ready(function() {

	page.loadAddress();

});

var page = {
	data: {
		address: [],
		isSetDefault: 0,
	},

	loadAddress: function() {
		var _this = this;

		function cdom(obj) {
			var addDiv = $('<div class="add-div"></div>');
			var uinfo = $('<div class="uinfo"></div>');
			var nat = $('<div></div>');
			nat.append('<text>' + obj.name + '</text>');
			nat.append('<text style="margin-left:20px">' + obj.tel + '</text>');
			uinfo.append(nat);
			var sydz = $('<text onclick="sauAddress(' + obj.id + ')">选用地址</text>');
			//uinfo.append(sydz);
			var addinfo = $('<div class="addinfo">' + obj.address + '&nbsp;' + obj.address_xq + '</div>');
			var addopes = $('<div class="addopes"></div>');
			addDiv.append(uinfo);
			addDiv.append(addinfo);
			addDiv.append(addopes);

			if(obj.is_default == '1') {
				var mrdzDiv = $('<div class="mrdz-div mui-input-row mui-checkbox mui-left"></div>');
				mrdzDiv.append('<input name="" value="" type="checkbox" checked disabled />');
			} else {
				var mrdzDiv = $('<div onclick="setDefault(' + obj.id + ')" class="mrdz-div mui-input-row mui-checkbox mui-left"></div>');
				mrdzDiv.append('<input name="" value="" type="checkbox" />');
			}
			mrdzDiv.append('<label>默认地址</label>');
			var opeRight = $('<div class="ope-right"></div>');
			var ed = $('<div onclick="editAddress(' + obj.id + ')" class="edit-div"></div>');
			ed.append('<img src="../img/wapApp/edit1.png" />编辑');
			var dd = $('<div class="del-div"></div>');
			if(obj.is_default != '1') dd.append('<img onclick="delAddress(' + obj.id + ')" src="../img/wapApp/dleicon.png" />删除');
			opeRight.append(ed);
			opeRight.append(dd);
			addopes.append(mrdzDiv);
			addopes.append(opeRight);

			$('.adds-div').append(addDiv);
		}

		mui.post(app.d.hostUrl + 'ApiUser/getAdds', {
			user_id: app.ls.get("uid")
		}, function(data) {
			var data = app.json.decode(data);

			if(data.status == 1) {
				_this.data.address = data.adds;
				$('.adds-div').html('');
				for(var i in data.adds) {
					cdom(data.adds[i]);
				}

				if(_this.data.isSetDefault == 1) mui.toast("设置成功");
			} else {
				alert(data.err);
			}

		});
	}
}

function setDefault(addrId) {
	mui.post(app.d.hostUrl + 'ApiUser/setAddsDefault', {
		uid: app.ls.get("uid"),
		addr_id: addrId
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			page.data.isSetDefault = 1;
			page.loadAddress();
		} else {
			alert(data.err);
		}
	});
}

function delAddress(addrId) {
	var btnArray = ['否', '是'];
	mui.confirm('你确认删除该地址吗?', '提示', btnArray, function(e) {
		if(e.index == 1) {
			mui.post(app.d.hostUrl + 'ApiUser/delAdds', {
				user_id: app.ls.get("uid"),
				addr_id: addrId
			}, function(data) {
				var data = app.json.decode(data);

				if(data.status == 1) {
					page.loadAddress();
				} else {
					alert(data.err);
				}
			});
		}
	});
}

function editAddress(id) {
	var body = $(document.body),
		form = $("<form method='post'></form>"),
		input;
	form.attr({
		"action": '../WPages/addressEditPage'
	});
	input = $("<input type='hidden'>");
	input.attr({
		"name": 'id'
	});
	input.val(id);
	form.append(input);
	form.appendTo(document.body);
	form.submit();
	document.body.removeChild(form[0]);

}