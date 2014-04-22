var bww;
var IMGW = 1700;
var wfx;
var wm;
var cycling = false;
var cycler;
var hseconds = 7;
var add1tweet = false;

function changeHome(lnk) {
	var $ = jQuery;
	if(lnk.parents('.thm').hasClass('on')==false) {
		$('#study').remove();
		var ldv = lnk.parents('div.thm');
		
		if($('#home img').size() > 0) {
			$("#home").append('<img src="'+lnk.attr('href')+'" style="left:'+wfx+'px" class="off" />');
			$('#home img:eq(0)').animate({ top: '-=475' },600).next().animate({ top: '-=475' },600,function() {
				$(this).removeClass().prev().remove();
				/*
				if(ldv.hasClass('firstslide')) {
					$('#freeform').fadeIn(300);
				}
				*/
			});
		} else {
			$("#home").append('<img src="'+lnk.attr('href')+'" style="left:'+wfx+'px" />');
			/*
			if(ldv.hasClass('firstslide')) {
				$('#freeform').fadeIn(300);
			}
			*/
		}
		$('#pros .thm.on').removeClass('on');
		lnk.parents('.thm').addClass('on');
		
		if(ldv.hasClass('firstslide') == false ) {
			var al = lnk.children('img').attr('alt');
			if ( al == 'petunia' ) {
				$('#home').append('<a href="http://www.petunia.com" target="_blank" id="study" style="left:'+(wfx+395)+'px" />');
			} else {
				$('#home').append('<a href="/work/'+al+'/" id="study" style="left:'+(wfx+370)+'px" />');
			}
			//$('#freeform').hide();
		}
		
		clearTimeout(cycler);
		cycler = setTimeout(homeTick,hseconds*1000);
//		hseconds = 7;
	}
	return false;
}

function slidem(lnk) {
	var $ = jQuery;
	var onn = lnk.siblings('.in').children('img.on');
	var nex = onn.next();
	var onnto = '-=850';
	var nexto = '850px';
	if(lnk.hasClass('n')) {
		if(nex.size()==0) nex = onn.parent().children('img:eq(0)');
	} else {
		nex = onn.prev();
		if(nex.size()==0) nex = onn.parent().children('img:last');
		onnto = '+=850';
		nexto = '-850px';
	}
	
	onn.animate({ left: onnto },400,function() {
		$(this).removeClass('on');
	});
	
	var hei = nex.height();
	nex.parent().animate({height: hei},300,function() {
		wm = $('#frap').offset();
		wm = wm.top;
	});
	
	nex.css('left',nexto).animate({ left: 0 },400,function() {
		$(this).addClass('on');
	});
}

function homeTick() {
	var $ = jQuery;
	var onn = $("#pros .on");
	var nex = onn.next();
	if(nex.hasClass('thm') == false) {
		nex = $('#pros').children('.thm:first');
	}
	nex.find('a').click();
}

function nlkTwitterCallback(twitters) {
  for (var i=0; i<twitters.length; i++){
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
    jQuery('#fboxT p.last').before('<p>'+status+'<br /><small>'+relative_time(twitters[i].created_at)+' via '+ twitters[i].source +'</small></p>');
  }
  if(add1tweet) nlkMyTwitter(twitters);
}

function nlkTwitterC2(twitters) {
  for (var i=0; i<twitters.length; i++){
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
    jQuery('#tweets').append('<p>'+status+'<br /><small>'+relative_time(twitters[i].created_at)+' via '+ twitters[i].source +'</small></p>');
  }
}


function nlkMyTwitter(twitters) {
	var $ = jQuery;
  for (var i=0; (i<twitters.length) && (i<1); i++){
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
	var mytweet = $('<div class="block tweet"><h3>Tweets <a href="http://twitter.com/'+twitters[i].user.screen_name+'" target="_blank" class="i">http://twitter.com/'+twitters[i].user.screen_name+'</a></h3><p>'+status+'<br /><small>'+relative_time(twitters[i].created_at)+' via '+ twitters[i].source +'</small></p></div>');
	if($('#months').size() > 0) {
		$('#months').after(mytweet);
	} else {
		$('#right').prepend(mytweet);
		if(i==0) {
			$('#us div.count.posts').after('<div class="count tweet typeface-js">'+twitters[i].user.statuses_count+'<span class="fx" /></div>');
		}
	}
  }
}

function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  if (delta < 60) {
    return 'less than a minute ago';
  } else if(delta < 120) {
    return 'about a minute ago';
  } else if(delta < (60*60)) {
    return (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (120*60)) {
    return 'about an hour ago';
  } else if(delta < (24*60*60)) {
    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
    return '1 day ago';
  } else {
    return (parseInt(delta / 86400)).toString() + ' days ago';
  }
}

function jsonFlickrFeed(flickr) {
	console.log('jsonFlickrFeed ing');
	var $ = jQuery;
	$('#right .block.links a[href^="http://www.flickr.com"]').html((flickr.link).substr(11,(flickr.link).length-12)).add('#us .follow ul li.fl a').attr('href',flickr.link);
	var flickhere = $('<div class="block flickr"><h3>Flickr <a href="'+flickr.link+'" target="_blank" class="i">'+flickr.link+'</a></h3><div id="pixhere"></div></div>');
	if($('#months').size() > 0) {
		$('#months').after(flickhere);
	} else {
		$('#right .block.links').before(flickhere);
	}
	$.each(flickr.items,function(i,v) {
		if(i<8) {
			var pic = $('<img src="'+ this.media.m +'" alt="'+ this.title +'" />');
			pic.load(function() {
				var w = $(this).width();
				var h = $(this).height();
				if(w > h) {
					$(this).addClass('l');
					var fx = Math.floor(32.5 - (w*32.5/h));
					$(this).css('left',fx+'px');
				}
			});
			$('#pixhere').append('<div class="pic"><a href="'+ this.link + '" target="_blank"></a></div>');
			pic.appendTo('#pixhere .pic:last a');
		}
	});
}

function nlkPicasa(picasa) {
	var $ = jQuery;
	$('#right .block.links').before('<div class="block picasa"><h3>Picasa <a href="'+picasa.feed.link[1].href+'" target="_blank" class="i">'+picasa.feed.link[1].href+'</a></h3><div id="pixhere"></div></div>');
	$.each(picasa.feed.entry,function(i,v) {
		if(i<8) {
			var pic = $('<img src="'+ this.content.src +'" alt="" />'); //'+ this.title['$t'] +'
			pic.load(function() {
				var w = $(this).width();
				var h = $(this).height();
				if(w > h) {
					$(this).addClass('l');
					var fx = Math.floor(32.5 - (w*32.5/h));
					$(this).css('left',fx+'px');
				}
			});
			$('#pixhere').append('<div class="pic"><a href="'+ this.link[1].href + '" target="_blank"></a></div>');
			pic.appendTo('#pixhere .pic:last a');
		}
	});
}

function nlkVimeo(vimeo) {
	var $ = jQuery;
	$('#right .block.links').before('<div class="block vimeo"><h3>Vimeo <a href="'+vimeo[0].user_url+'" target="_blank" class="i">'+vimeo[0].user_url+'</a></h3></div>');
	$('#right .block.vimeo').append('<object width="293" height="194"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="wmode" value="opaque" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='+vimeo[0].id+'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='+vimeo[0].id+'&amp;server=vimeo.com&amp;show_title=1&amp;show_byline=0&amp;show_portrait=0&amp;color=00ADEF&amp;fullscreen=1&amp;autoplay=0&amp;loop=0" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="293" height="194" wmode="opaque"></embed></object>');
}

function nlkQuote() {
	jQuery("#bar .fbox.quot .bin").addClass('thx').empty();
}

function nlkPostTick() {
	var $ = jQuery;
	var onn = $(this).parent().siblings('div.on');
	var nex = onn.next();
	if($(this).hasClass('p')) {
		nex = onn.prev();
		if(nex.hasClass('arr')) nex = onn.nextAll('div:last');
	} else {
		if(nex.size()==0) nex = onn.parent().children('div:first');
	}
	
	onn.fadeOut(200,function() {
		$(this).removeClass('on');
		nex.fadeIn(200,function() { jQuery(this).addClass('on'); });
	});
	
	if(cycling) {
		clearTimeout(cycler);
		cycler = setTimeout("jQuery('#"+(($("#shm").size() > 0) ? "shm" : "btick")+" .arr a.n').click()",5000);
	}
	return false;
}

jQuery(document).ready(function($) {	
	var whash = '' + window.location.hash;
	var slideget = 0;
	$(window).resize(function() {
		bww = $(window).width();
		wfx = (bww>1063) ? Math.ceil((bww-IMGW)/2) : -321;
		if(bww < 990) {
			$('#bar').addClass('no');
		} else {
			$('#bar').removeClass('no');
		}
	}).resize();
	if($('#home').size() > 0) {
		/*
		$('#home img').each(function() {
			var imgsrc = $(this).attr('src');
			$('#pros').prepend('<div class="thm firstslide"><div><a href="'+imgsrc+'"><img src="'+imgsrc+'" /></a></div></div>');
			$(this).remove();
		});
		*/
		$('#pros a').click(function() { return changeHome($(this)); }).eq(0).click().parents('.thm').addClass('firstslide');
		$('#home').removeAttr('style');
		//preload
		$('body').append('<div id="preload" style="display:none" />');
		$('#pros div a').each(function() {
			$('#preload').append('<img src="'+ $(this).attr('href') + '" />');
		});
		// arrowd
		if ( $('#pros .thm').size() > 6 ) {
			$('#pros .thm:gt(5)').hide();
			$('#pros').append('<a href="#p" class="ar p"></a><a href="#n" class="ar n"></a>').children('.ar').click(function() {
				if ( $(this).hasClass('p') ) {
					var onn = $('#pros .thm:visible').filter(':first');
					var nex = onn.prev();
					if ( nex.size() > 0 ) {
						nex.show();
						nex.parent().children('.thm:visible').filter(':last').hide();
					}
				} else {
					var onn = $('#pros .thm:visible').filter(':last');
					var nex = onn.next();
					if ( nex.hasClass('thm') ) {
						nex.show();
						nex.parent().children('.thm:visible').filter(':first').hide();
					}
				}
				return false;
			});
		}
		// cycler = setTimeout(homeTick,hseconds*1000);
		$(window).resize(function() {
			$('#home img').css('left',wfx+'px');
			//$('#freeform').css('left',(wfx+1080)+'px');
		}).trigger('resize');
		/*
		$('#freeform input.txt').bind({
			focus: function() {
				clearTimeout(cycler);
			},
			blur: function() {
				clearTimeout(cycler);
				cycler = setTimeout(homeTick,4000);
			}
		});
		*/
	}
	
	$('.flickr-photos').each(function() {
		$(this).addClass('in').wrap('<div class="sfx" />').before('<div class="t" />');
		$(this).after('<div class="e" />');
		$(this).children().each(function(i) {
			if(i==0) $(this).children().addClass('on');
			$(this).children().insertBefore($(this));
			$(this).remove();
		});
		$(this).after('<a href="#prev" class="p"></a><a href="#next" class="n"></a>');
		$(this).siblings('a').click(function() { slidem($(this)); return false; });
		$(this).height(function(ind, hei) {
			var kh = $(this).children('img.on').height();
			return (kh>40 ? kh : hei);
		});
	});
	
	if($('#serv').size() > 0) {
		$('#images').attr('id','bimg').appendTo('#hdr');
		$('#bimg img').hide();
		whash = '' + window.location.hash;
		slideget = 0;
		$('#serv .tabs a').each(function(i) {
			var hre = $(this).attr('href');
			if(whash!='' && (hre.indexOf(whash) > -1)) slideget = i;
			$(this).click(function() {
				$(this).parent().addClass('on').siblings('.tabs.on').removeClass('on');
				$(this).parent().parent().children('.tab:eq('+i+')').addClass('on').siblings('.tab.on').removeClass('on');
				$('#bimg img:eq('+i+')').show().siblings(':visible').hide();
			});
		});
		$('#serv .tabs a:eq('+slideget+')').click();
	}
	
	if(($('#bimg').size() > 0) && ($('body').hasClass('pl')==false)) {
		$(window).resize(function() {
			$('#bimg img').css('left',wfx).parent().show();
		}).resize();
	}
	
	wm = $('#frap').offset();
	wm = wm.top;
	$(window).scroll(function() {
		var wend = $(window).scrollTop() + $(window).height();
		if(wend < wm) {
			$('#bar').addClass('flo');
		} else {
			$('#bar').removeClass('flo');
		}
	}).scroll();
	
	$('#bar h3 a').each(function(i) {
		$(this).click(function() {
			$(this).parent().parent().toggleClass('on');
			/*
			if(i==0) { // chat with a pro!
				if($(this).parent().parent().hasClass('on')) {
					var chatlink = $(this).parent().next().children('a:first');
					chatlink.hide();
					var chref = chatlink.attr('href');
					if(chref=='http://www.ninthlink.com/contact/') {
						window.location = chref;
					} else {
						$(this).parent().next().append('<iframe width="292" height="235" frameborder="0" src="'+chatlink.attr('href')+'"></iframe>');
					}
				} else {
					$(this).parent().next().children('iframe').remove();
				}
			}
			*/
			return false;
		});
	});
	
	$('ul.tabs li a').click(function() {
		$(this).parent().addClass('on').siblings('.on').removeClass('on');
		// error correct IE ?
		var onid = $(this).attr('href');
		$(onid).addClass('on').siblings('.tab.on').removeClass('on');
		return false;
	});
	
	$('#months select').change(function() {
		$(this).siblings('ul').hide().filter(':eq('+$(this).val()+')').show();
	});
	
	$('#bullseye input.txt').each(function() {
		$(this).attr('title',$(this).val());
		$(this).focus(function() {
			if($(this).val()==$(this).attr('title')) $(this).val('');
		}).blur(function() {
			if($(this).val()=='') $(this).val($(this).attr('title'));
		});
	});
	
	if($('#shm div.on, #btick').size() > 0) {
		$("#shm, #btick").prepend('<span class="arr"><a href="#p" class="p" /><a href="#n" class="n" /></span>').children('.arr').children('a').click(nlkPostTick);
		cycling = true;
		cycler = setTimeout("jQuery('#"+(($("#shm").size() > 0) ? "shm" : "btick")+" .arr a.n').click()",5000);
		//else cycler = setTimeout("jQuery('#btick .arr a.n').click()",5000);
	}
	
	if($('#right').hasClass('request')) {
		$('#right label').each(function() {
			$(this).addClass('jq').click(function() { jQuery(this).next().children().focus(); return false; });
			$(this).next().children().bind({
				focus: function() {
					jQuery(this).parent().prev().addClass('bye');
				},
				blur: function() {
					jQuery(this).parent().prev().removeClass('bye');
				}
			});
		});
	}
	var cli = $('#clients');
	if((cli.size() > 0) && (cli.hasClass('all') == false)) {
		cycler = $('#clients .thms a.pthm').size();
		$('#clients .thms').prepend('<a href="#prev" class="prev" /><a href="#next" class="next" />');
		$('#clients .thms a.prev').click(function() {
			var onn = $('#clients .thms a.pthm:visible').eq(0);
			onn.nextAll(':visible').eq(3).hide();
			if(onn.prev().hasClass('next')) {
				onn.nextAll(':hidden:last').insertBefore(onn).show();
			} else {
				onn.prev().show();
			}
			return false;
		});
		$('#clients .thms a.next').click(function() {
			var onn = $('#clients .thms a.pthm:visible:first').hide().nextAll(':visible:last');
			if(onn.next().size()==0) {
				onn.parent().children('a.pthm:eq(0)').insertAfter(onn).show();
			} else {
				onn.next().show();
			}
			return false;
		});
	}
	
	$('.stBubble .stBubble_count').html(function(index, html) {
		return (html=='New') ? '0' : html;
	});
	
	stButtons.getCount=function(c,a,e) {
		var b=false;
		for(var d=0;
		d<stButtons.counts.length;
		d++) {
			var g=stButtons.counts[d];
			if(g.ourl==c) {
				b=true;
				var h="";
				try {
					if(a=="sharethis") {
						h=(g.total>0)?stButtons.human(g.total):"0"
					}
					else {
						if(a=="facebook"&&typeof(g.facebook2)!="undefined") {
							h=stButtons.human(g.facebook2)
						}
						else {
							if(typeof(g[a])!="undefined") {
								h=(g[a]>0)?stButtons.human(g[a]):"0"
							}
							else {
								h="0"
							}
						}
					}
					e.appendChild(document.createTextNode(h))
				}
				catch(f) {
				}
			}
		}
		if(b==false) {
			stButtons.getCountsFromService(c,a,e)
		}
	};
});