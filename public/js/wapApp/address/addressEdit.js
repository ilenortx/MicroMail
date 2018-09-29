$(function() {
	/**
	 * 通过数组id获取地址列表数组
	 *
	 * @param {Number} id
	 * @return {Array} 
	 */
	function getAddrsArrayById(id) {
		var results = [];
		if(addr_arr[id] != undefined)
			addr_arr[id].forEach(function(subArr) {
				results.push({
					key: subArr[0],
					val: subArr[1]
				});
			});
		else {
			return;
		}
		return results;
	}
	/**
	 * 通过开始的key获取开始时应该选中开始数组中哪个元素
	 *
	 * @param {Array} StartArr
	 * @param {Number|String} key
	 * @return {Number} 
	 */
	function getStartIndexByKeyFromStartArr(startArr, key) {
		var result = 0;
		if(startArr != undefined)
			startArr.forEach(function(obj, index) {
				if(obj.key == key) {
					result = index;
					return false;
				}
			});
		return result;
	}

	$("#ssq").click(function() {
		var PROVINCES = [],
			startCities = [],
			startDists = [];
		addr_arr[0].forEach(function(prov) {
			PROVINCES.push({
				key: prov[0],
				val: prov[1]
			});
		});
		var $input = $(this),
			dataKey = $input.attr("data-key"),
			provKey = 1,
			cityKey = 36,
			distKey = 37,
			distStartIndex = 0,
			cityStartIndex = 0,
			provStartIndex = 0;

		if(dataKey != "" && dataKey != undefined) {
			var sArr = dataKey.split("-");
			if(sArr.length == 3) {
				provKey = sArr[0];
				cityKey = sArr[1];
				distKey = sArr[2];

			} else if(sArr.length == 2) {
				provKey = sArr[0];
				cityKey = sArr[1];
			}
			startCities = getAddrsArrayById(provKey);
			startDists = getAddrsArrayById(cityKey);
			provStartIndex = getStartIndexByKeyFromStartArr(PROVINCES, provKey);
			cityStartIndex = getStartIndexByKeyFromStartArr(startCities, cityKey);
			distStartIndex = getStartIndexByKeyFromStartArr(startDists, distKey);
		}
		var navArr = [{
			title: "省",
			id: "scs_items_prov"
		}, {
			title: "市",
			id: "scs_items_city"
		}, {
			title: "区",
			id: "scs_items_dist"
		}];
		SCS.init({
			navArr: navArr,
			onOk: function(selectedKey, selectedValue) {
				$input.val(selectedValue).attr("data-key", selectedKey);
			}
		});
		var distScroller = new SCS.scrollCascadeSelect({
			el: "#" + navArr[2].id,
			dataArr: startDists,
			startIndex: distStartIndex
		});
		var cityScroller = new SCS.scrollCascadeSelect({
			el: "#" + navArr[1].id,
			dataArr: startCities,
			startIndex: cityStartIndex,
			onChange: function(selectedItem, selectedIndex) {
				distScroller.render(getAddrsArrayById(selectedItem.key), 0);
			}
		});
		var provScroller = new SCS.scrollCascadeSelect({
			el: "#" + navArr[0].id,
			dataArr: PROVINCES,
			startIndex: provStartIndex,
			onChange: function(selectedItem, selectedIndex) {
				cityScroller.render(getAddrsArrayById(selectedItem.key), 0);
				distScroller.render(getAddrsArrayById(cityScroller.getSelectedItem().key), 0);
			}
		});
	});
});

function formSubmit() {
	var name = $('#name').val();
	var ssq = $('#ssq').val();
	var xxdz = $('#xxdz').val();
	var tel = $('#tel').val();

	if(!name) {
		mui.toast('请填写用户名', {
			duration: 'long',
			type: 'div'
		});
		return false;
	} else if(!ssq) {
		mui.toast('请选择省/市/区', {
			duration: 'long',
			type: 'div'
		});
		return false;
	} else if(!xxdz) {
		mui.toast('请填写详细地址', {
			duration: 'long',
			type: 'div'
		});
		return false;
	} else if(!tel) {
		mui.toast('请填写手机号', {
			duration: 'long',
			type: 'div'
		});
		return false;
	}else if (!app.isPoneAvailable(tel)){
		mui.toast('手机号格式错误', {
			duration: 'long',
			type: 'div'
		});
		return false;
	}

	var id = $('#id').val();

	var url = id ? 'ApiUser/editAdds' : 'ApiUser/addAdds';

	mui.post(app.d.hostUrl + url, {
		user_id: app.ls.get("uid"),
		receiver: name,
		tel: tel,
		region: ssq,
		adds: xxdz,
		id: id
	}, function(data) {
		var data = app.json.decode(data);

		if(data.status == 1) {
			app.pageGoBack(-1);
		} else {
			alert(data.err);
		}
	});
}