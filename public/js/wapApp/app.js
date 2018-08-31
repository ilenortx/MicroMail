var app = {
	d: {
		//hostUrl: 'http://x.viphk.ngrok.org/MicroMail/',
		//hostUrl: 'http://localhost/MicroMail/',
		//hostUrl: 'https://wx.yingyuncn.com/',
		hostUrl: 'http://localhost/MicroMail/',

		//hostImg: 'http://x.viphk.ngrok.org/MicroMail/public/files/uploadFiles/',
		//hostImg: 'http://localhost/MicroMail/public/files/uploadFiles/',
		//hostImg: 'https://wx.yingyuncn.com/public/files/uploadFiles/',
		hostImg: 'http://localhost/MicroMail/public/files/uploadFiles/',

		hostVideo: 'https://wx.yingyuncn.com/public/files/uploadFiles/',

		//ceshiUrl: 'http://x.viphk.ngrok.org/MicroMail/',
		//ceshiUrl: 'http://localhost/MicroMail/',
		ceshiUrl: 'https://wx.yingyuncn.com/',

		userId: 1,
		userInfo: [],
		appId: "",
		appKey: "",

		shareTitle: '最具人气的微商城!',
		shopId: 'all',
		shopInfo: [],
		fxsId: 0, //分销商id
		fxsStatus: 0, //分销商状态
	},

	onLaunch: function() {
		this.hideWxShare();
	},

	getUid: function() { //获取uid，如果未登陆返回false
		this.ls.get('uid');
	},

	ls: { //本地存储封装
		save: function(key, value) { //保存数据
			if(key) {
				localStorage.setItem(key, value);
				return true;
			} else return false;
		},
		get: function(key) { //获取数据
			if(key) {
				return localStorage.getItem(key);
			} else return false;
		}
	},

	json: { //JSON操作
		decode: function(json) { //json解析
			return JSON.parse(json);
		},
		encode: function(arr) { //数组转json
			return JSON.stringify(arr);
		}
	},

	pageGoBack: function(num, reload) { //返回上级
		num = num ? num : -1;
		javascript: history.go(num);
		if(reload) location.reload();
	},
	pageBackTo: function(num, reload) { //控制返回键返回
		num = num ? num : -1;
		history.pushState(null, null, document.URL);
		window.addEventListener('popstate', function() {
			window.history.go(num);
			/*history.pushState(null, null, document.URL);*/
		});
		if(reload) location.reload();
	},

	goLogin: function() { //跳转登陆
		window.location.href = "../WPages/loginPage";
	},

	post: function(url, datas) {
		var body = $(document.body),
			form = $("<form action='" + url + "' method='post' target='_parent'></form>"),
			input;
		var arr = Object.keys(datas);
		if(arr.length) {
			for(var k in datas) {
				//document.write("<input type='hidden' name='"+k+"' value='"+datas[k]+"'/>");
				input = $("<input type='hidden' name='" + k + "' value='" + datas[k] + "'>");
				form.append(input);
			}
		}

		form.appendTo(document.body);
		form.submit();
		document.body.removeChild(form[0]);

		return false;
	},

	isWxBrowser: function() { //判断是否是微信浏览器的函数
		var ua = window.navigator.userAgent.toLowerCase();
		//通过正则表达式匹配ua中是否含有MicroMessenger字符串
		if(ua.match(/MicroMessenger/i) == 'micromessenger') {
			return true;
		} else {
			return false;
		}
	},

	timeFormat: function(t) { //活动结束时间
		var time = t - parseInt(Number(new Date()) / 1000);
		var day = parseInt(time / 86400);
		var h = parseInt((time - day * 86400) / 3600);
		var m = parseInt((time - day * 86400 - h * 3600) / 60);
		var s = time - day * 86400 - h * 3600 - m * 60;
		m = m < 10 ? '0' + m : m;
		s = s < 10 ? '0' + s : s;

		var ftime = day == 0 ? '' : day + '天';
		if(h > 0) ftime += h + ':';
		if(m >= 0) ftime += m + ':';
		if(s >= 0) ftime += s;

		return ftime;
	},

	wxShare: function(obj) {
		var _this = this;
		var conf = {
			title:'', desc:'', link:'', imgUrl:'', success:null, cancel:null, fail:null
		}
		$.extend(conf, obj);
		if(this.isWxBrowser()) {
			var _this = this;
			// _this.loadJs('http://res.wx.qq.com/open/js/jweixin-1.2.0.js');
			_this.loadJs('https://res.wx.qq.com/open/js/jweixin-1.0.0.js');
			$.ajax({
				url: "../Wuser/wxShareConf",
				type: "POST",
				data: "url=" + location.href.split('#')[0],
				async: true,
				cache: false,
				dataType: "json",
				success: function(data) {
					wx.config({
						debug: false,
						appId: data.appId,
						timestamp: data.timestamp,
						nonceStr: data.nonceStr,
						signature: data.signature,
						jsApiList: [
							'onMenuShareAppMessage',
							'onMenuShareTimeline',
							'hideOptionMenu',
							'showOptionMenu'
						]
					});

					wx.ready(function() {
						wx.checkJsApi({
                			jsApiList: ['onMenuShareAppMessage','onMenuShareTimeline'],
            			});
						wx.showOptionMenu();
						wx.onMenuShareAppMessage({
							title: conf.title,
							desc: conf.desc,
							link: conf.link,
							imgUrl: conf.imgUrl,
							trigger: function(res) {},
							success: function(res) {
								if(conf.success != null) conf.success();
							},
							cancel: function(res) {
								if(conf.cancel != null) conf.cancel();
							},
							fail: function(res) {
								if(conf.fail != null) conf.fail();
							}
						});

						wx.onMenuShareTimeline({
							title: conf.title,
							desc: conf.desc,
							link: conf.link,
							imgUrl: conf.imgUrl,
							trigger: function(res) {},
							success: function(res) {
								if(conf.success != null) conf.success();
							},
							cancel: function(res) {
								if(conf.cancel != null) conf.cancel();
							},
							fail: function(res) {
								if(conf.fail != null) conf.fail();
							}
						});

						wx.error(function(res) {
							//alert(res.errMsg);
						});
					});
				},
				error: function() {
					alert('ajax request failed!!!!');
					return;
				}
			});
		}
	},

	hideWxShare: function() {
		function onBridgeReady() {
			WeixinJSBridge.call('hideOptionMenu');
		}

		if(typeof WeixinJSBridge == "undefined") {
			if(document.addEventListener) {
				document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
			} else if(document.attachEvent) {
				document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
				document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
			}
		} else {
			onBridgeReady();
		}
	},

	loadJs: function(url, callback) { //动态 加载js
		var script = document.createElement("script");
		script.type = "text/javascript";
		if(typeof(callback) != "undefined") {
			if(script.readyState) {
				script.onreadystatechange = function() {
					if(script.readyState == "loaded" || script.readyState == "complete") {
						script.onreadystatechange = null;
						callback();
					}
				};
			} else {
				script.onload = function() {
					callback();
				};
			}
		}
		script.src = url;
		document.getElementsByTagName('head')[0].appendChild(script);
	},

	getObjLength: function(obj) { //获取obj长度
		var arr = Object.keys(obj);

		return arr.length;
	},

	pullRefresh: { //上拉加载更多下拉刷新
		up: function(container, callback) {
			mui(container).pullRefresh({
				up: {
					contentrefresh: "正在加载...",
					contentnomore: '没 有 更 多 数 据 了',
					callback: function() {
						callback(function(status) {
							mui(container).pullRefresh().endPullupToRefresh(status);
						});
					}
				}
			});
		},
		down: function(container, callback, auto) {
			auto = auto ? true : false;
			mui(container).pullRefresh({
				down: {
					auto: auto,
					contentdown: "下拉可以刷新",
					contentover: "释放立即刷新",
					contentrefresh: "正在刷新...",
					callback: function() {
						callback(function(status) {
							mui(container).pullRefresh().endPulldownToRefresh();
							mui(container).pullRefresh().refresh(true);
						});
					}
				}
			});
		},
		both: function(container, ucallback, dcallback, auto) {
			auto = auto ? true : false;
			mui(container).pullRefresh({
				up: {
					contentrefresh: "正在加载...",
					contentnomore: '没 有 更 多 数 据 了',
					callback: function() {
						ucallback(function(status) {
							mui(container).pullRefresh().endPullupToRefresh(status);
						});
					}
				},
				down: {
					auto: auto,
					contentdown: "下拉可以刷新",
					contentover: "释放立即刷新",
					contentrefresh: "正在刷新...",
					callback: function() {
						dcallback(function(status) {
							mui(container).pullRefresh().endPulldownToRefresh();
							mui(container).pullRefresh().refresh(true);
						});
					}
				}
			});
		}
	},

	getCookie: function (name) {//获取cookie
		var strcookie = document.cookie; //获取cookie字符串
		var arrcookie = strcookie.split("; "); //分割
		//遍历匹配
		for(var i = 0; i < arrcookie.length; i++) {
			var arr = arrcookie[i].split("=");
			if(arr[0] == name) {
				return arr[1];
			}
		}
		return "";
	},

	getUrlParam: function(e) {
	    var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)");
	    var a = window.location.search.substr(1).match(t);
	    if (a != null) return a[2];
	    return ""
	},

}

app.onLaunch();