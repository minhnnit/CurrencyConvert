<?php

/* document:
 - run: not set or =1 to run =0 to off
 - url: link hoac function call back co the su dung $this trong function cua class UpdateCoupon /helpers
 - box: box coupon items, neu la array ['find' => item, 'parent' => parent of item, 'pindex'=> index of parent default: 0
        + hoac function callback($html object) { co the gop tung box list lai de tao box item -> loai bo box ko mong muon; }
 - get: du lieu can lay ten tuong ung trong insertCpToDB()
        + value is string: get plaintext index 0
        + value is array -> cau truc get:
            'nameget' => ['find'=>'tham chieu den element', 'index'=>'default(0) 0,1,2...cua element', ->'attr'=>'default plaintext or src...', 'func'=>function callback($item) {...} $item=tham chieu cua 0,1
*/


return [
	'Dealspotr.com' => [
		'url' => 'https://dealspotr.com/promo-codes/[domain]',
        'proxy' => 1,
		'note' => '',
		'box' => function($html) {
				$htmlcreate = new \Htmldom();
				$items = $html->find('section');
				$box = '';
				foreach($items as $v) {
					$ch = $v->childNodes();
					foreach($ch as $c) {
						$box .= '<div class="items">' . $c->innertext .'</div>';
					}
				}
				$htmlcreate->load($box);
				return $htmlcreate->childNodes();
			},
		'get' => [
			'title' => 'h3 a',
			'code' => ['find' => 'span', 'func'=>function($item) {
				    if(strtoupper($item->plaintext)==$item->plaintext && strpos(trim($item->plaintext), ' ')===false) return $item->plaintext;return '';
				}],
			'desc' => '',
			'expired' => '',
			'discount' => '',
			'verify' => ['find' => 'button i', 'func' => function($item) {return $item?1:0;} ]
		]
	
	],
	
    'Couponasion.com' => [
        'url' => 'https://www.couponasion.com/uk/[domain]',
        'note' => '',
	'box' => ['parent'=>'.block-wrapper', 'find'=>'.coupon'],
	'get' => [
            'title' => '.coupon-title',
            'code' => [ 'find'=>'.coupon-action a', 'attr'=>'data-clip-code' ],
            'desc' => '',
            'expired' => ['find'=>'.add-info','func'=>function($item) {
                        $span = $item->find('i',0);
                        if($span) $span->innertext = '';
                        if($expired = $item->find('span',0)) {
                            $expired = str_replace(' ','',$expired->plaintext);
                            $expired = explode('-', $expired);
                            if(count($expired)>1) {
                                $expired = '20' . $expired[2] . '-' . $expired[1] . '-' . $expired[0];
                                return $expired;
                            }
                        }
                        return '';
                    }],
            'discount' => ['find'=>'.amount'],
            'verify' => ''
            ]
    ],

    'Couponsherpa.com' => [
        'url' => 'https://www.couponsherpa.com/[alias]/',
        'note' => '',
	'box' => 'div[class="offer list"] .box',
	'get' => [
            'title' => 'h3',
            'code' => ['find'=>'.coupon_code .code', 'func'=>function($items){return trim($items->plaintext);}],
            'desc' => '',
            'expired' => ['find' => '.extras .expires', 'func' => function($item){
                                return str_ireplace('Expires ', '', $item->plaintext);
                            }],
            'discount' => ['find'=>'.deal div', 'func' => function($item){
                                return str_ireplace('Off', '', $item->plaintext);
                            }],
            'verify' => ''
            ]
    ],

    'GoodSearch.com' => [
        'url' => 'https://www.goodsearch.com/coupons/[alias]',
        'note' => '',
	'box' => '.deal-item',
	'get' => [
            'title' => ['find'=>'span[class="title"]'],
            'code' => ['find'=>'span[class="code"]'],
            'desc' => '',
            'discount' => ['find'=>'span[class="span_text"]'],
            'verify' => ['find'=>'.verified', 'func'=>function($item){return $item?1:0;} ]
            ]
    ],

    'Promotioncode.com' => [
	'run' => 0, //die
        'url' => 'https://www.promotioncode.org/[alias]',
        'note' => '',
	'box' => '.click',
	'get' => [
            'title' => 'p',
            'code' => '.click-view span',
            'desc' => '',
            'discount' => '.',
            'verify' => ''
            ]
    ],

    'Bradsdeals.com' => [
        'url' => 'https://www.bradsdeals.com/coupons/[alias]',
        'note' => '',
	'box' => 'li[class="block coupon"]',
	'get' => [
            'title' => 'h3 a',
            'code' => '.coupon-code',
            'desc' => '.coupon-description',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'Savevy.com' => [
        'url' => 'http://www.savevy.com/store/[domain]',
        'note' => '',
	'box' => '.media',
	'get' => [
            'title' => 'h3',
            'code' => ['find'=>'a[class="hint hint--right"]', 'attr'=>'code'],
            'desc' => '.index_coupon_code p',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'Dealhack.com' => [
        'url' => 'https://dealhack.com/coupons/[alias]',
        'note' => '',
	'box' => ['parent'=>'#content .box-holder', 'find'=>'.item'],
	'get' => [
            'title' => '.entry-title span',
            'code' => '.hidden-code',
            'desc' => '',
            'discount' => ['find'=>'div[class="free-gift text"]', 'func'=>function($item){
                                        return str_ireplace('Off','', $item->plaintext);
                                    }],
            'verify' => ''
            ]
    ],

    'Couponforless.com' => [
        'url' => 'http://couponforless.com/store/[domain]',
        'note' => '',
	'box' => '.offer-item',
	'get' => [
            'title' => 'h3 a',
            'code' => ['find'=>'.code a', 'attr'=>'data-clipboard-text'],
            'desc' => '.offer-description',
            'discount' => '',
            'verify' => ''
            ]
    ],

    '360couponcodes.com' => [
        'url' => 'https://www.360couponcodes.com/[domain]',
        'note' => '',
	'box' => '.coupon-details',
	'get' => [
            'title' => 'h3 a',
            'code' => '#description2',
            'desc' => '',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'couponology.com' => [
        'url' => 'http://www.couponology.com/[alias]-coupon',
        'note' => '',
	'box' => 'article',
	'get' => [
            'title' => 'h3',
            'code' => "span[id^='couponcontent1_CurrentPromoListView_Label2_']",
            'desc' => '.couponDescription',
            'discount' => '',
            'verify' => [ 'find'=>'.featured-coupon', 'func'=>function($item) {return $item?1:0;} ]
            ]
    ],

    'Slickdeals.com' => [
        'url' => 'https://slickdeals.net/coupons/[alias]/',
        'note' => '',
	'box' => 'div[class="item"]',
	'get' => [
            'title' => 'span[class="title cpbtn"]',
            'code' => ['find' => '.buttonRight a', 'attr' => 'data-clipboard-text'],
            'desc' => '.extra',
            'discount' => ['find' => '.intro .top', 'func' => function($item) {
                                            if($item) return str_replace(['ONSALE', 'OFF'],'', $item->plaintext);
                                            return '';
                                        }],
            'verify' => ['find' => '.verified', 'func' => function($item) {return $item?1:0;} ]
            ]
    ],


    'Couponlawn.com' => [
        'url' => 'http://couponlawn.com/store-coupons/[alias]-coupons/',
        'note' => '',
	'box' => '.item',
	'get' => [
            'title' => ['find'=>'h3', 'func' => function($item) {
                return strip_tags($item->plaintext);
            }],
            'code' => ['find'=>'.code-cover a', 'attr'=>'data-rel'],
            'desc' => '.desc',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'Getcouponcodes.com' => [
        'url' => 'https://getcouponcodes.com/coupon-code/[alias]',
        'note' => '',
	'box' => '.item',
	'get' => [
            'title' => ['find' => '.itemdesc', 'func' => function($item) {return strip_tags($item->plaintext);} ],
            'code' => '.code-text',
            'desc' => '#note_box',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'Coupontwo.com' => [
        'url' => 'http://www.coupontwo.com/coupons/[domain]',
        'note' => '',
	'box' => '.media-body',
	'get' => [
            'title' => ['find' => 'h3', 'func' => function($item) {return strip_tags($item->plaintext);} ],
            'code' => ['find' => '.coupon_code_box a', 'attr'=>'code'],
            'desc' => 'p',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'savedoubler.com' => [
        'url' => 'https://www.savedoubler.com/[alias]-promo-codes.html',
        'note' => '',
	'box' => '.offer-item',
	'get' => [
            'title' => '.offer-title',
            'code' => ['this' => 1, 'attr' => 'data-code'],
            'desc' => '.offer-anchor span',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'Couponsgood.com' => [
        'url' => 'http://www.couponsgood.com/coupons/[domain]',
        'note' => '',
	'box' => '.store_coupons_small',
	'get' => [
            'title' => '.store_coupons_title',
            'code' => ['find' => "input[type='hidden']", 'func'=>function($item){return $item->value;}],
            'desc' => '',
            'discount' => '',
            'verify' => ''
            ]
    ],

    'Copypromocode.com' => [
        'url' => function($alias, $aliasDomain=''){
            $url = "http://cuponaz.com/shop/[domain]";
            $html = $this->getHtmlViaProxy($url);
            $finditem = $html->find('.coupon-right a',0);
            if(!$finditem||!$finditem->getAttribute('coupon-url')) return '';
            $url = "http://cuponaz.com".$finditem->getAttribute('coupon-url');//echo $url;exit;
            return $url;
        },
        'note' => '',
	'box' => '.offer-item',
	'get' => [
            'title' => '.offer-title',
            'code' => ['this' => 1, 'attr' => 'data-code'],
            'desc' => '',
            'discount' => '.offer-anchor span',
            'verify' => ''
            ]
    ],

    'Anyalles.com' => [
        'url' => function($alias, $aliasDomain=''){
            $url = "http://anyalles.com/coupons/$alias.html";
            $html = $this->getHtmlViaProxy($url);
            $finditem = $html->find('article[class="padding1"]',0);
            if(!$finditem||!$finditem->find('#to', 0)) return '';
            preg_match('#^(.+?)/(\d+)\.html$#', $finditem->find('#to',0)->{"data-url"}, $idFirst);
            $idFirst = $idFirst[2];
            $url = "http://anyalles.com/coupon-code/$alias/$idFirst.html";//echo $url;exit;
            return $url;
        },
        'ref' => function($alias) {return "http://anyalles.com/coupons/$alias.html";},
        'note' => '',
	'box' => 'article[class="padding1"]',
	'get' => [
            'title' => '.coupon-title h3',
            'code' => ['find'=>'.copy', 'attr'=>'data-clipboard-text'],
            'desc' => '.coupon-summary',
            'expired' => ['find' => '.coupon-expire', 'func' => function($item) {return str_replace('Expired: ','', $item->plaintext);} ],
            'discount' => '',
            'verify' => ''
            ]
    ],


    '123promocode.com' => [
        'run' => 0, //0 choc dc
        'url' => 'https://www.123promocode.com/[domain]',
        'note' => '',
        'box' => ['find' => '.coupon-list', 'parent' => '.media-list'],
        'get' => [
            'title' => '.offer-title',
            'code' => ['this' => 1, 'attr' => 'data-code'],
            'desc' => '',
            'discount' => '.offer-anchor span',
            'verify' => ''
        ]
    ],


    'couponcodeyear.com' => [
        'run' => 1,
        'url' => function($alias, $aliasDomain=''){
            $url = "http://couponcodeyear.com/coupons/$alias.html";
            $html = $this->getHtmlViaProxy($url);
            $finditem = $html->find('.offers',0);
            if(!$finditem||!$finditem->find('.out-coupons', 0)) return '';
            preg_match('#^(.+?)/(\d+)\.html$#', $finditem->find('.out-coupons',0)->{"data-coupon-url"}, $idFirst);
            $idFirst = $idFirst[2];
            $url = "http://couponcodeyear.com/coupon-code/$alias/$idFirst.html";//echo $url;exit;
            return $url;
        },
        'ref' => function($alias) {return "http://couponcodeyear.com/coupons/$alias.html";},
        'note' => '',
        'box' => ['parent'=>'#coupon-list', 'find' => '.offers'],
        'get' => [
            'title' => 'h3',
            'code' => ['find'=>'.coupon-cta-label'],
            'desc' => '.nopadding span',
            'discount' => '',
            'verify' => ''
        ]
    ],


    'nopaymoney.com' => [
        'run' => 1,
        'url' => function($alias='', $aliasDomain='') {
            $url = "http://www.nopaymoney.com/store/$aliasDomain.html";
            $html = $this->getHtmlViaProxy($url);
            $finditem = $html->find('article',0);
            if(!$finditem||!$finditem->find('.coupon-code-link', 0)) return '';
                preg_match('#^(.+?)/(\d+)\.html$#', $finditem->find('.coupon-code-link', 0)->{"data-url"}, $idFirst);
                $idFirst = $idFirst[2];
                $url = "http://www.nopaymoney.com/store/$aliasDomain/$idFirst.html";//echo $url;exit;
                return $url;
        },
        'note' => '',
        'box' => ['parent'=>'.lists', 'find' => 'article'],
        'get' => [
            'title' => '.coupon-title a',
            'code' => ['find'=>'.coupon-code-link .coupon-print span'],
            'desc' => '.nopadding span',
            'expired' => ['find' => '.coupon-expire', 'func' => function($item) {
                    $expr = trim(str_ireplace('Expire: ','', $item->plaintext));
                    $expr = explode('-', $expr);
                    if(count($expr)>1) {
                        return $expr[2].'-'.$expr[0].'-'.$expr[1];
                    }
                    return '';
                }],
            'discount' => '',
            'verify' => ''
        ]
    ],


    'couponzguru.com' => [
        'run' => 1,
        'url' => 'https://www.couponzguru.com/[alias]/',
        'note' => '',
        'box' => '.coupon-list',
        'get' => [
            'title' => 'h3 a',
            'code' => ['find' => '.hide .clicktoreveal-code'],
            'desc' => '.coupon-description p',
            'expired' => '',
            'discount' => '.offer-anchor span',
            'verify' => ''
        ]
    ],

    'couponrani.com' => [
        'run' => 1,
        'url' => 'http://www.couponrani.com/[alias]-coupons',
        'note' => '',
        'box' => ['parent'=>'.coupons_list', 'find' => 'section'],
        'get' => [
            'title' => 'h3 a',
            'code' => ['find' => '.btn-default', 'attr'=>'data-coupon'],
            'desc' => '.coupon_short_desc',
            'expired' => ['find' => '.expiresspan', 'func' => function($item) {return str_replace('Expires-','', $item->plaintext);}],
            'discount' => ['find'=>'.offer_badge', 'func'=>function($item){
                $dis1 = $item->find('span',0);
                $dis2 = $item->find('span',1);
                if($dis1) $dis1 = $dis1->plaintext;
                if($dis2) $dis2 = $dis2->plaintext;
                return str_ireplace('Off','', $dis1 . $dis2);
            }],
            'verify' => ['find'=>'.glyphicon-ok', 'func'=>function($item) {return $item?1:0;}]
        ]
    ],


    'coupert.com' => [
        'run' => 0, //co cho
        'url' => 'https://www.coupert.com/us/[domain]',
        'note' => '',
        'box' => ['find' => '.coupon-list', 'parent' => '#tabList'],
        'get' => [
            'title' => '.offer-text a',
            'code' => ['.coupon-btn', 'func'=>function($item) {
                     $span = $item->find('span',0);
                     if($span) $span->innertext = '';
                     return $item->plaintext;
                }],
            'desc' => '',
            'expired' => ['.icon-span', 'func'=>function($item) {
                $span = $item->find('span',0);
                if($span) $span->innertext = '';
                return $item->plaintext;
            }],
            'discount' => ['find'=>'.code-num', 'func'=>function($item){
                $dis1 = $item->find('span',0);
                $dis2 = $item->find('span',1);
                if($dis1) $dis1 = $dis1->plaintext;
                if($dis2) $dis2 = $dis2->plaintext;
                return str_ireplace('Off','', $dis1 .' '. $dis2);
            }],
            'verify' => ['find'=>'.fa-check', 'func'=>function($item) { return $item->{"aria-hidden"}=='true';}]
        ]
    ],


    'dealsea.com' => [
        'run' => 1,
        'url' => 'https://dealsea.com/view/[domain]',
        'note' => '',
        'box' => ['parent'=>'#col1', 'find' => '.coupon'],
        'get' => [
            'title' => 'h3 a',
            'code' => ['find' => '.crux strong'],
            'desc' => '.crux p',
            'expired' => ['find' => '.expiration', 'func' => function($item) {return str_replace('Expires ','', $item->plaintext);}],
            'discount' => '',
            'verify' => ''
        ]
    ],


    'promocodewatch.com' => [
        'run' => 1,
        'url' => 'https://www.promocodewatch.com/[alias]-promo-code',
        'note' => '',
        'box' => ['parent'=>'.coupon-list', 'find' => '.coupon'],
        'get' => [
            'title' => '.description a',
            'code' => ['find' => '.code-text p'],
            'desc' => '.details-cont .details p',
            'expired' => ['find' => '.card-meta p', 'index' => 1, 'func' => function($item) {
    return date('Y-m-d H:i:s', strtotime(trim(str_replace('Expires ','', $item->plaintext))));
                }],
            'discount' => ['find'=>'.discount-amount', 'func'=>function($item){
                $dis1 = $item->find('div',0);
                $dis2 = $item->find('div',1);
                if($dis1) $dis1 = $dis1->plaintext;
                if($dis2) $dis2 = $dis2->plaintext;
                return str_ireplace('Off','', $dis1 . $dis2);
            }],
            'verify' => ''
        ]
    ],

    'ultimatecoupons.com' => [
        'run' => 1,
        'url' => 'https://www.ultimatecoupons.com/coupons/[domain]_coupons.htm',
        'note' => '',
        'box' => function($html) {
            $htmlcreate = new \Htmldom();
            $box_1 = $html->find('#verifiedOffers',0);
            $box_2 = $html->find('#verified-productsOffers',0);
            $box_3 = $html->find('#unverifiedOffers',0);
            $htmlcreate->load(($box_1?$box_1->innertext:'') . ($box_2?$box_2->innertext:'') . ($box_3?$box_3->innertext:''));
            return $htmlcreate->find('article');
        },
        'get' => [
            'title' => '.offer-content-left h3 a',
            'code' => 'span[class="code"]',
            'desc' => '',
            'expired' => '',
            'discount' => '',
            'verify' => ['find'=>'.offer-details', 'func'=>function($item) { return $item->plaintext=='verified';}]
        ]
    ],

    'chameleonjohn.com' => [
        'run' => 1,
        'url' => "https://www.chameleonjohn.com/store/[alias]-coupon-codes",
        'note' => '',
        'box' => ['parent' => '.coupons-list', 'find' => '.item'],
        'get' => [
            'title' => '.name h3',
            'code' => ['this' => 1, 'attr' => 'data-coupon-code'],
            'desc' => '.detailed-description',
            'expired' => '',
            'discount' => '',
            'verify' => ''
        ]
    ],

    'chameleonjohn.com' => [
        'run' => 1,
        'url' => "https://www.promocodesforyou.com/[alias]-coupons/?showcode=1",
        'note' => '',
        'box' => ['parent' => '.lp-detail-section', 'find' => '.coupon-row'],
        'get' => [
            'title' => '.deal-name a',
            'code' => '.coupon-code span',
            'desc' => '',
            'expired' => '',
            'discount' => '',
            'verify' => ''
        ]
    ],

    'givingassistant.org' => [
        'run' => 1,
        'url' => "https://givingassistant.org/coupon-codes/[domain]",
        'note' => '',
        'box' => ['parent' => '#active_coupon_grid_container', 'find' => '.home_box'],
        'get' => [
            'title' => '.discount_detail',
            'code' => '.coupon-code span',
            'desc' => '',
            'expired' => '',
            'discount' => '',
            'verify' => ['find'=>'.discount_detail_2', 'func'=>function($item){return $item->find('img',0)?1:0;}]
        ]
    ],


    'joinhoney.com' => [
        'run' => 1,
        'url' => "https://www.joinhoney.com/shop/[alias]?hasOpened=1",
        'note' => '',
        'box' => ['parent' => 'div[data-radium="true"]', 'find' => 'div[class^="container-"]'],
        'get' => [
            'title' => 'h2[class^="titleText"]',
            'code' => 'textarea',
            'desc' => '',
            'expired' => '',
            'discount' => '',
            'verify' => ''
        ]
    ],

    'theblackfriday.com' => [
        'run' => 1,
        'url' => "https://www.theblackfriday.com/coupons/[alias]-coupons/",
        'note' => '',
        'box' => function($html) {
            if($html->find('#logo_id'))
                return $html->find('.coupons li');
            return false;
            },
        'get' => [
            'title' => 'h4',
            'code' => '.see-through strong',
            'desc' => '',
            'expired' => '',
            'discount' => '',
            'verify' => ''
        ]
    ],

    'dealcatcher.com' => [
        'run' => 1,
        'url' => 'https://www.dealcatcher.com/[alias]-coupons?id=99',
        'note' => '',
        'box' => ['parent'=>'.main-content section', 'find'=>'article'],
        'useTamp' => ['html'=>1],
        'get' => [
            'title' => 'h3 a',
            'code' => [
                'this'=>1, 'func'=> function($item) {
                    if($item->find('.coupon-code')) {
                    if(isset($this->dataTamp['dealcatcher'])===false) {
                        $sid = $this->dataTamp['html']->find('#merchant-aside',0)->{'data-merchant_id'};
                        $dataCode = json_decode(file_get_contents('https://www.dealcatcher.com/do/deals/get_coupon_codes_on_merchant_page?merchant_id='.$sid));
                        $this->dataTamp['dealcatcher'] = $dataCode;
                    }else $dataCode = $this->dataTamp['dealcatcher'];
                        $did = $item->{'data-id'};
                        foreach($dataCode as $v) {
                            if($v->id == $did) $codeId = $v->code;
                        }
                        return $codeId;
                    }else return '';
                }
            ],
            'desc' => '.description',
            'expired' => ['find'=>'.expire','func'=>function($item) {
                if($item) {
                    $expired = trim(str_replace('Expires ','',$item->plaintext));
                    if($expired) {
                        $expired = explode('/', $expired);
                        $expired = '20' . $expired[2] . '-' . $expired[0] . '-' . $expired[1];
                        return $expired;
                    }
                }
                return '';
            }],
            'discount' => '',
            'verify' => ['find'=>'.deal-verified', 'func'=>function($item) { return $item?1:0;}]
        ]
    ],



    'grabon.in' => [
        'run' => 1,
        'url' => "https://www.grabon.in/[alias]-coupons/",
        'note' => '',
        'box' => ['parent' => '#category_coupons', 'find'=>'article'],
        'get' => [
            'title' => 'h3',
            'code' => '.go-cpBtn span',
            'desc' => '.desshow ol',
            'expired' => '',
            'discount' => ['find'=>'.go-couponOff', 'func' => function($item) {
                if($item) return str_ireplace('OFF','', $item->plaintext);
                return '';
            }],
            'verify' => ''
        ]
    ],


    'rather-be-shopping.com' => [
        'run' => 1,
        'url' => "https://www.rather-be-shopping.com/coupons/[alias]",
        'note' => '',
        'box' => ['parent' => 'ul.coupons', 'find' => 'li[id^="coupon"]'],
        'get' => [
            'title' => '.title a',
            'code' => ['find'=>'.code a', 'func'=>function($item) {
                     if($item) return str_ireplace('None Needed','',$item->plaintext);
                     return '';
            }],
            'desc' => '',
            'expired' => ['find'=>'.expire', 'func' => function($item) {
                if($item) {
                    $expired = trim($item->plaintext);
                    if(stripos($expired, 'N/A')===false) {
                        $expired = explode('/', $expired);
                        $expired = $expired[2] . '-' . $expired[0] . '-' . $expired[1];
                        return $expired;
                    }
                }
                return '';
            }],
            'discount' => '',
            'verify' => ''
        ]
    ],



    'radins.com' => [
        'run' => 1,
        'url' => function($alias='', $aliasDomain='') {
            $url = "https://www.radins.com/code-promo/$alias/";
            $html = $this->getHtmlViaProxy($url);
            $finditem = $html->find('.item',0);
            if($finditem) {
                $idFirst = str_replace('coupon-', '', $finditem->id);
                $url = "https://www.radins.com/code-promo/$alias/?showCode=$idFirst";//echo $url;exit;
                return $url;
            }else
                return '';
        },
        'note' => '',
        'box' => ['parent' => '#coupon-list', 'find' => '.item'],
        'get' => [
            'title' => '.title-item',
            'code' => ['find'=>'.show-code input', 'func'=>function($item){return $item->value;}],
            'desc' => '.description p',
            'expired' => ['find'=>'.expired-date span', 'index'=>1, 'func' => function($item) {
                if($item) {
                    $expired = trim($item->plaintext);
                    if($expired) {
                        $expired = explode('/', $expired);
                        $expired = $expired[2] . '-' . $expired[1] . '-' . $expired[0];
                        return $expired;
                    }
                }
                return '';
            }],
            'discount' => '',
            'verify' => ''
        ]
    ],


    'dontpayfull.com' => [
        'run' => 1,
        'url' => 'https://www.dontpayfull.com/at/[domain]',
        'note' => '',
        'box' => ['parent'=>'#active-coupons', 'find' => '.obox'],
        'get' => [
            'title' => '.otitle',
            'code' => ['find' => '.ocode'],
            'desc' => '.odescription .shortcontent',
            'expired' => ['find' => '.expiration', 'func' => function($item) {return str_replace('Expires ','', $item->plaintext);}],
            'discount' => '',
            'verify' => ['find'=>'.verified', 'func'=>function($item) {return $item?1:0;}]
        ]
    ],


];


