(window.vcvWebpackJsonp4x=window.vcvWebpackJsonp4x||[]).push([[0],{"./node_modules/babel-runtime/core-js/json/stringify.js":function(e,n,t){e.exports={default:t("./node_modules/core-js/library/fn/json/stringify.js"),__esModule:!0}},"./node_modules/core-js/library/fn/json/stringify.js":function(e,n,t){var o=t("./node_modules/core-js/library/modules/_core.js"),a=o.JSON||(o.JSON={stringify:JSON.stringify});e.exports=function(e){return a.stringify.apply(a,arguments)}},"./node_modules/raw-loader/index.js!./row/cssMixins/columnGap.pcss":function(e,n){e.exports=".vce-row--col-gap-$gap {\n\n  @if $gap != false {\n    > .vce-row-content {\n      > .vce-col {\n        margin-right: $(gap)px;\n      }\n\n      > .vce-column-resizer .vce-column-resizer-handler {\n        width: $(gap)px;\n      }\n    }\n  }\n}\n\n.rtl .vce-row--col-gap-$gap,\n.rtl.vce-row--col-gap-$gap {\n  @if $gap != false {\n    > .vce-row-content {\n      > .vce-col {\n        margin-left: $(gap)px;\n        margin-right: 0;\n      }\n    }\n  }\n}"},"./node_modules/raw-loader/index.js!./row/styles.css":function(e,n){e.exports='/* ----------------------------------------------\n * Row\n * ---------------------------------------------- */\n.vce {\n  margin-bottom: 30px;\n}\n.vce-row {\n  position: relative;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n  margin-left: 0;\n  margin-right: 0;\n}\n.vce-row-content > .vce-col:last-child {\n  margin-right: 0;\n}\n.vce-row-full-height {\n  min-height: 100vh;\n}\n.vce-row-content {\n  -webkit-box-flex: 1;\n      -ms-flex: 1 1 auto;\n          flex: 1 1 auto;\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-orient: horizontal;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: row;\n          flex-direction: row;\n  -ms-flex-wrap: wrap;\n      flex-wrap: wrap;\n  -webkit-box-pack: start;\n      -ms-flex-pack: start;\n          justify-content: flex-start;\n  -ms-flex-line-pack: start;\n      align-content: flex-start;\n  -webkit-box-align: start;\n      -ms-flex-align: start;\n          align-items: flex-start;\n  min-height: 1em;\n  position: relative;\n}\n.vce-row-wrap--reverse > .vce-row-content {\n  -ms-flex-wrap: wrap-reverse;\n      flex-wrap: wrap-reverse;\n  -ms-flex-line-pack: end;\n      align-content: flex-end;\n  -webkit-box-align: end;\n      -ms-flex-align: end;\n          align-items: flex-end;\n}\n.vce-row-columns--top > .vce-row-content {\n  -ms-flex-line-pack: start;\n      align-content: flex-start;\n}\n.vce-row-columns--top.vce-row-wrap--reverse > .vce-row-content {\n  -ms-flex-line-pack: end;\n      align-content: flex-end;\n}\n.vce-row-columns--middle > .vce-row-content {\n  -ms-flex-line-pack: center;\n      align-content: center;\n}\n.vce-row-columns--bottom > .vce-row-content {\n  -ms-flex-line-pack: end;\n      align-content: flex-end;\n}\n.vce-row-columns--bottom.vce-row-wrap--reverse > .vce-row-content {\n  -ms-flex-line-pack: start;\n      align-content: flex-start;\n}\n.vce-row-columns--top > .vce-row-content:after,\n.vce-row-columns--middle > .vce-row-content:after,\n.vce-row-columns--bottom > .vce-row-content:after {\n  content: "";\n  width: 100%;\n  height: 0;\n  overflow: hidden;\n  visibility: hidden;\n  display: block;\n}\n.vce-row-content--middle > .vce-row-content > .vce-col > .vce-col-inner {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-pack: center;\n      -ms-flex-pack: center;\n          justify-content: center;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n}\n.vce-row-content--bottom > .vce-row-content > .vce-col > .vce-col-inner {\n  display: -webkit-box;\n  display: -ms-flexbox;\n  display: flex;\n  -webkit-box-pack: end;\n      -ms-flex-pack: end;\n          justify-content: flex-end;\n  -webkit-box-orient: vertical;\n  -webkit-box-direction: normal;\n      -ms-flex-direction: column;\n          flex-direction: column;\n}\n.vce-row-equal-height > .vce-row-content {\n  -webkit-box-align: stretch;\n      -ms-flex-align: stretch;\n          align-items: stretch;\n}\n.vce-row-columns--stretch > .vce-row-content {\n  -ms-flex-line-pack: stretch;\n      align-content: stretch;\n  -webkit-box-align: stretch;\n      -ms-flex-align: stretch;\n          align-items: stretch;\n}\n.vce-row[data-vce-full-width="true"] {\n  position: relative;\n  -webkit-box-sizing: border-box;\n          box-sizing: border-box;\n}\n.vce-row[data-vce-stretch-content="true"] {\n  padding-left: 30px;\n  padding-right: 30px;\n}\n.vce-row[data-vce-stretch-content="true"].vce-row-no-paddings {\n  padding-left: 0;\n  padding-right: 0;\n}\n.vce-row.vce-element--has-background {\n  padding-left: 30px;\n  padding-right: 30px;\n  padding-top: 30px;\n}\n.vce-row.vce-element--has-background[data-vce-full-width="true"]:not([data-vce-stretch-content="true"]) {\n  padding-left: 0;\n  padding-right: 0;\n}\n.vce-row.vce-element--has-background.vce-row--has-col-background {\n  padding-bottom: 30px;\n}\n.vce-row > .vce-row-content > .vce-col.vce-col--all-last {\n  margin-right: 0;\n}\n.rtl .vce-row > .vce-row-content > .vce-col.vce-col--all-last,\n.rtl.vce-row > .vce-row-content > .vce-col.vce-col--all-last {\n  margin-left: 0;\n}\n@media (min-width: 0) and (max-width: 543px) {\n  .vce-row.vce-element--xs--has-background {\n    padding-left: 30px;\n    padding-right: 30px;\n    padding-top: 30px;\n  }\n  .vce-row.vce-element--xs--has-background[data-vce-full-width="true"]:not([data-vce-stretch-content="true"]) {\n    padding-left: 0;\n    padding-right: 0;\n  }\n  .vce-row.vce-element--xs--has-background.vce-row--xs--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--xs--has-background.vce-row--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--has-background.vce-row--xs--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row > .vce-row-content > .vce-col.vce-col--xs-last {\n    margin-right: 0;\n  }\n  .rtl .vce-row > .vce-row-content > .vce-col.vce-col--xs-last,\n  .rtl.vce-row > .vce-row-content > .vce-col.vce-col--xs-last {\n    margin-left: 0;\n  }\n}\n/* styles for mobile-landscape */\n@media (min-width: 544px) and (max-width: 767px) {\n  .vce-row.vce-element--sm--has-background {\n    padding-left: 30px;\n    padding-right: 30px;\n    padding-top: 30px;\n  }\n  .vce-row.vce-element--sm--has-background[data-vce-full-width="true"]:not([data-vce-stretch-content="true"]) {\n    padding-left: 0;\n    padding-right: 0;\n  }\n  .vce-row.vce-element--sm--has-background.vce-row--sm--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--sm--has-background.vce-row--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--has-background.vce-row--sm--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row > .vce-row-content > .vce-col.vce-col--sm-last {\n    margin-right: 0;\n  }\n  .rtl .vce-row > .vce-row-content > .vce-col.vce-col--sm-last,\n  .rtl.vce-row > .vce-row-content > .vce-col.vce-col--sm-last {\n    margin-left: 0;\n  }\n}\n/* styles for mobile-landscape */\n@media (min-width: 768px) and (max-width: 991px) {\n  .vce-row.vce-element--md--has-background {\n    padding-left: 30px;\n    padding-right: 30px;\n    padding-top: 30px;\n  }\n  .vce-row.vce-element--md--has-background[data-vce-full-width="true"]:not([data-vce-stretch-content="true"]) {\n    padding-left: 0;\n    padding-right: 0;\n  }\n  .vce-row.vce-element--md--has-background.vce-row--md--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--md--has-background.vce-row--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--has-background.vce-row--md--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row > .vce-row-content > .vce-col.vce-col--md-last {\n    margin-right: 0;\n  }\n  .rtl .vce-row > .vce-row-content > .vce-col.vce-col--md-last,\n  .rtl.vce-row > .vce-row-content > .vce-col.vce-col--md-last {\n    margin-left: 0;\n  }\n}\n/* styles for mobile-landscape */\n@media (min-width: 992px) and (max-width: 1199px) {\n  .vce-row.vce-element--lg--has-background {\n    padding-left: 30px;\n    padding-right: 30px;\n    padding-top: 30px;\n  }\n  .vce-row.vce-element--lg--has-background[data-vce-full-width="true"]:not([data-vce-stretch-content="true"]) {\n    padding-left: 0;\n    padding-right: 0;\n  }\n  .vce-row.vce-element--lg--has-background.vce-row--lg--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--lg--has-background.vce-row--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--has-background.vce-row--lg--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row > .vce-row-content > .vce-col.vce-col--lg-last {\n    margin-right: 0;\n  }\n  .rtl .vce-row > .vce-row-content > .vce-col.vce-col--lg-last,\n  .rtl.vce-row > .vce-row-content > .vce-col.vce-col--lg-last {\n    margin-left: 0;\n  }\n}\n/* styles for mobile-landscape */\n@media (min-width: 1200px) {\n  .vce-row.vce-element--xl--has-background {\n    padding-left: 30px;\n    padding-right: 30px;\n    padding-top: 30px;\n  }\n  .vce-row.vce-element--xl--has-background[data-vce-full-width="true"]:not([data-vce-stretch-content="true"]) {\n    padding-left: 0;\n    padding-right: 0;\n  }\n  .vce-row.vce-element--xl--has-background.vce-row--xl--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--xl--has-background.vce-row--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row.vce-element--has-background.vce-row--xl--has-col-background {\n    padding-bottom: 30px;\n  }\n  .vce-row > .vce-row-content > .vce-col.vce-col--xl-last {\n    margin-right: 0;\n  }\n  .rtl .vce-row > .vce-row-content > .vce-col.vce-col--xl-last,\n  .rtl.vce-row > .vce-row-content > .vce-col.vce-col--xl-last {\n    margin-left: 0;\n  }\n}\n'},"./row/component.js":function(e,n,t){"use strict";Object.defineProperty(n,"__esModule",{value:!0});var o=g(t("./node_modules/babel-runtime/helpers/extends.js")),a=g(t("./node_modules/babel-runtime/core-js/object/get-prototype-of.js")),l=g(t("./node_modules/babel-runtime/core-js/json/stringify.js")),c=g(t("./node_modules/babel-runtime/core-js/object/keys.js")),i=g(t("./node_modules/babel-runtime/helpers/classCallCheck.js")),r=g(t("./node_modules/babel-runtime/helpers/possibleConstructorReturn.js")),s=g(t("./node_modules/babel-runtime/helpers/createClass.js")),d=g(t("./node_modules/babel-runtime/helpers/inherits.js")),u=g(t("./node_modules/react/index.js")),p=g(t("./node_modules/vc-cake/index.js")),v=g(t("./node_modules/lodash/lodash.js"));function g(e){return e&&e.__esModule?e:{default:e}}var m=p.default.getService("api"),h=p.default.getService("document"),w=p.default.getStorage("assets"),f=["all","defaultSize","xs","sm","md","lg","xl"],b=function(e){function n(e){(0,i.default)(this,n);var t=(0,r.default)(this,(n.__proto__||(0,a.default)(n)).call(this,e));return t.state={layout:{}},t}return(0,d.default)(n,e),(0,s.default)(n,null,[{key:"getRowData",value:function(e){for(var n=[],t=0,o=0,a=[],l=!0,c=e.slice();c.lastIndexOf("hide")===c.length-1&&c.length;)l=!1,c.splice(c.lastIndexOf("hide"),1);c.forEach(function(e,i){var r=0;if("hide"===e)l=!1;else if("auto"===e||""===e)r=.01,a.push("auto"),o++;else{if(e.indexOf("%")>-1)r=parseFloat(e.replace("%","").replace(",","."))/100;else{var s=e.split("/");r=s[0]/s[1]}a.push(r)}var d=Math.floor(1e3*(t+r))/1e3;(d>1||1===d&&"hide"===e)&&(l=!1,n.push(i-1),t=0),void 0===c[i+1]&&n.push(i),t+=r});var i=0,r=(1-(t-.01*o))/o;return a.forEach(function(e,n){"auto"===e?(a[n]=r,i+=r):i+=e}),a.forEach(function(e){a[0]!==e&&1!==e&&(l=!1)}),{lastColumnIndex:n,isColumnsEqual:l,rowValue:i}}},{key:"resetRowLayout",value:function(e){var n=h.get(e);n.layout.layoutData=null,h.update(e,n)}},{key:"getDefaultLayout",value:function(e,n){var t=[];n&&n.hasOwnProperty("all")?t=n.all.slice():h.children(e).forEach(function(e){e.size.hasOwnProperty("defaultSize")&&t.push(e.size.defaultSize)});return t}},{key:"setColumns",value:function(e,t,o){var a=arguments.length>3&&void 0!==arguments[3]&&arguments[3],l=h.children(e),i=[],r=[],s={tag:"column",parent:e,designOptionsAdvanced:{},customClass:"",customHeaderTitle:"",metaCustomId:"",dividers:{},sticky:{},lastInRow:{},firstInRow:{},size:{}},d=null;(0,c.default)(t).forEach(function(e){var c=t[e],u=o&&o[e];if(u&&u.length)if(c.length>u.length){var p=n.getRowData(u);if(Math.round(100*p.rowValue)/100<1){var g=1-p.rowValue;(c=u).push(100*g+"%")}else if(p.isColumnsEqual){var m=c.length,h=Math.floor(100/m*100)/100+"%";c=[];for(var w=0;w<m;w++)c.push(h)}}else if(c.length<u.length){var f=n.getRowData(u);if(Math.round(100*f.rowValue)/100==1&&f.isColumnsEqual){var b=c.length,x=Math.floor(100/b*100)/100+"%";c=[];for(var y=0;y<b;y++)c.push(x)}}var k=n.getRowData(c).lastColumnIndex,_=0;c.forEach(function(n,t){var o=k.indexOf(t)>-1,c=0===t||k.indexOf(t-1)>-1;if(void 0!==l[t]){(d=l[t]).size[e]=n,"defaultSize"!==e&&(d.lastInRow[e]=o,d.firstInRow[e]=c),d.disableStacking=a;var u=!1;i.forEach(function(e,n){d.id===e.id&&(i[n]=d,u=!0)}),u||i.push(d)}else{if(r[_]){var p=r[_];p.size[e]=n,"defaultSize"!==e&&(p.lastInRow[e]=o,p.firstInRow[e]=c),p.disableStacking=a}else{var g=v.default.defaultsDeep({},s);g.size[e]=n,"defaultSize"!==e&&(g.lastInRow[e]=o,g.firstInRow[e]=c),g.disableStacking=a,r.push(g)}_+=1}})}),i.forEach(function(e){t.hasOwnProperty("all")?(delete e.size.xs,delete e.size.sm,delete e.size.md,delete e.size.lg,delete e.size.xl):delete e.size.all,h.update(e.id,e)}),r.forEach(function(e){h.create(e)});var u=t.all||t.xs;u&&l.length>u.length&&l.slice(u.length).forEach(function(e){h.children(e.id).forEach(function(e){e.parent=d.id,h.update(e.id,e)}),h.delete(e.id)})}},{key:"getLayout",value:function(e){var n={},t=h.children(e),o=!1;return t.forEach(function(e){e.size.hasOwnProperty("xs")&&(o=!0)}),t.forEach(function(e){!o&&e.size.all&&(n.hasOwnProperty("all")||(n.all=[]),n.all.push(e.size.all)),e.size.defaultSize&&(n.hasOwnProperty("defaultSize")||(n.defaultSize=[]),n.defaultSize.push(e.size.defaultSize))}),n.hasOwnProperty("all")||f.forEach(function(e){"defaultSize"!==e&&"all"!==e&&t.forEach(function(t){t.size[e]&&(n.hasOwnProperty(e)||(n[e]=[]),n[e].push(t.size[e])),o&&t.size.hasOwnProperty("all")&&(n.hasOwnProperty(e)||(n[e]=[]),"xs"===e||"sm"===e?n[e].push("100%"):n[e].push(t.size.all))})}),n}},{key:"getDerivedStateFromProps",value:function(e,t){if(!p.default.env("FT_ROW_COLUMN_LOGIC_REFACTOR"))return null;var o=e.atts,a=e.id,c=o.layout&&o.layout.layoutData?o.layout.layoutData:n.getLayout(a),i=o.layout&&o.layout.layoutData;if((0,l.default)(c)!==(0,l.default)(t.layout)){if(i)return n.setColumns(a,i,null,o.layout.disableStacking),n.resetRowLayout(a),setTimeout(function(){w.trigger("updateElement",a)},10),{layout:i};var r=n.getLayout(a);return n.setColumns(a,r,t.layout,o.layout.disableStacking),setTimeout(function(){w.trigger("updateElement",a)},10),{layout:r}}return null}}]),(0,s.default)(n,[{key:"render",value:function(){var e=t("./node_modules/classnames/index.js"),n=this.props,a=n.id,l=n.atts,c=n.editor,i=n.isBackend,r=l.customClass,s=l.rowWidth,d=l.removeSpaces,p=l.columnGap,v=l.fullHeight,g=l.metaCustomId,m=l.equalHeight,h=l.columnPosition,w=l.contentPosition,f=l.designOptionsAdvanced,b=l.layout,x=l.columnBackground,y=l.hidden,k=l.sticky,_=this.props.children,C=window.VCV_EDITOR_TYPE?window.VCV_EDITOR_TYPE():"default",j=e({"vce-row-container":!0,"vce-wpbackend-element-hidden":y&&i}),O=["vce-row"];if(x)if(x.all)O.push("vce-row--has-col-background");else for(var S in x)x[S]&&O.push("vce-row--"+S+"--has-col-background");O.push(this.getBackgroundClass(f)),O.push("vce-row--col-gap-"+(p?parseInt(p):0)),b&&b.reverseColumn&&!b.disableStacking&&O.push("vce-row-wrap--reverse");var R={style:{}},E={style:{}},z={};"string"==typeof r&&r&&O.push(r),"stretchedRow"===s||"stretchedRowAndColumn"===s?E["data-vce-full-width"]=!0:(E.style.width="",E.style.left="",E.style.right="",R.style.paddingLeft="",R.style.paddingRight=""),"stretchedRowAndColumn"!==s&&"sidebar"!==C||(E["data-vce-stretch-content"]=!0);var A={};k&&k.device&&(A=this.getStickyAttributes(k)),"sidebar"!==C&&"stretchedRowAndColumn"!==s||!d||O.push("vce-row-no-paddings"),v?O.push("vce-row-full-height"):E.style.minHeight="",m&&"stretch"!==h&&O.push("vce-row-equal-height"),h&&O.push("vce-row-columns--"+h),w&&O.push("vce-row-content--"+w);var P=e(O);g&&(z.id=g),z["data-vce-delete-attr"]="style",E["data-vce-delete-attr"]="style",R["data-vce-element-content"]=!0;var I=this.applyDO("all");return u.default.createElement("div",(0,o.default)({className:j},z),u.default.createElement("div",(0,o.default)({className:P},E,A,c,{id:"el-"+a},I),this.getBackgroundTypeContent(),this.getContainerDivider(),u.default.createElement("div",(0,o.default)({className:"vce-row-content"},R),_)))}}]),n}(m.elementComponent);n.default=b},"./row/index.js":function(e,n,t){"use strict";var o=l(t("./node_modules/vc-cake/index.js")),a=l(t("./row/component.js"));function l(e){return e&&e.__esModule?e:{default:e}}t("./row/migrationWPB.js"),(0,o.default.getService("cook").add)(t("./row/settings.json"),function(e){e.add(a.default)},{css:t("./node_modules/raw-loader/index.js!./row/styles.css"),editorCss:!1,mixins:{columnGap:{mixin:t("./node_modules/raw-loader/index.js!./row/cssMixins/columnGap.pcss")}}},"")},"./row/migrationWPB.js":function(e,n,t){"use strict";var o=function(e){return e&&e.__esModule?e:{default:e}}(t("./node_modules/babel-runtime/core-js/object/assign.js")),a=t("./node_modules/vc-cake/index.js");var l=(0,a.getService)("cook"),c=(0,a.getStorage)("migration"),i={};c.on("migrateElement",function(e){if("vc_row"===e.tag||"vc_row_inner"===e.tag){var n=(0,o.default)({},function(e,n){var t=(0,o.default)({},{designOptionsAdvanced:{device:{all:{}}}},e,{tag:"row",rowWidth:"boxed"});if("stretch_row"===(n=(0,o.default)({full_width:"",gap:"0",full_height:"",columns_placement:"",equal_height:"",content_placement:"",video_bg:"",video_bg_url:"https://www.youtube.com/watch?v=lMJXxhRFO1k",video_bg_parallax:"",parallax:"",parallax_image:"",parallax_speed_video:"1.5",parallax_speed_bg:"1.5",css_animation:"",disable_element:""},n)).full_width?t.rowWidth="stretchedRow":"stretch_row_content"===n.full_width?t.rowWidth="stretchedRowAndColumn":"stretch_row_content_no_spaces"===n.full_width&&(t.rowWidth="stretchedRowAndColumn",t.removeSpaces=!0),n.full_height&&(t.fullHeight=!0,n.columns_placement?t.columnPosition=n.columns_placement:t.columnPosition="middle"),n.gap&&(t.columnGap=""+(parseInt(n.gap)+30)),n.equal_height&&(t.equalHeight=!0),n.content_placement&&(t.contentPosition=n.content_placement,"middle"===n.content_placement?t.equalHeight=!0:"bottom"===n.content_placement&&(t.equalHeight=!0)),n.disable_element&&(t.hidden=!0),n.video_bg&&(t.designOptionsAdvanced.device.all.backgroundType="videoYoutube",t.designOptionsAdvanced.device.all.videoYoutube=n.video_bg_url?n.video_bg_url:i.video_bg_url),n.parallax){"content-moving"===n.parallax?t.designOptionsAdvanced.device.all.parallax="simple":"content-moving-fade"===n.parallax&&(t.designOptionsAdvanced.device.all.parallax="simple-fade");var a=n.parallax_speed_bg||i.parallax_speed_bg||"1.5";t.designOptionsAdvanced.device.all.parallaxSpeed=6*parseFloat(a),t.designOptionsAdvanced.device.all.backgroundType="imagesSimple";var l=parseInt(n.parallax_image),c=window.VCV_API_WPBAKERY_WPB_MEDIA&&window.VCV_API_WPBAKERY_WPB_MEDIA()[n.parallax_image],r=t.designOptionsAdvanced.device.all;l&&c&&(r.images&&r.images.hasOwnProperty("ids")?(t.designOptionsAdvanced.device.all.images.ids.push(l),t.designOptionsAdvanced.device.all.images.urls.push({full:c,id:l})):t.designOptionsAdvanced.device.all.images={ids:[l],urls:[{full:c,id:l}]},r.backgroundStyle||(r.backgroundStyle="cover"))}return t}(e._generalElementAttributes,e._attrs)),t=l.get(n);c.trigger("add",t.toJS(),!1),e._subInnerContent&&e._parse(e._multipleShortcodesRegex,e._subInnerContent,t.get("id")),e._migrated=!0}})},"./row/settings.json":function(e){e.exports={customClass:{type:"string",access:"public",value:"",options:{label:"Extra class name",description:"Add an extra class name to the element and refer to it from Custom CSS option."}},layout:{type:"rowLayout",access:"public",value:{},options:{label:"Row Layout"}},dividers:{type:"divider",access:"public",value:{},options:{label:"Dividers"}},sticky:{type:"sticky",access:"public",value:{},options:{label:"Sticky"}},designOptionsAdvanced:{type:"designOptionsAdvanced",access:"public",value:{},options:{label:"Design Options"}},editFormTab1:{type:"group",access:"protected",value:["rowWidth","removeSpaces","columnGap","fullHeight","columnPosition","equalHeight","contentPosition","metaCustomId","customClass"],options:{label:"General"}},metaEditFormTabs:{type:"group",access:"protected",value:["editFormTab1","layout","designOptionsAdvanced","dividers","sticky"]},relatedTo:{type:"group",access:"protected",value:["General","RootElements","Row"]},containerFor:{type:"group",access:"protected",value:["Column"]},parentWrapper:{type:"string",access:"protected",value:""},metaOrder:{type:"number",access:"protected",value:2},rowWidth:{type:"buttonGroup",access:"public",value:"boxed",options:{label:"Row width",values:[{label:"Boxed",value:"boxed",icon:"vcv-ui-icon-attribute-row-width-boxed"},{label:"Stretched Row",value:"stretchedRow",icon:"vcv-ui-icon-attribute-row-width-stretched"},{label:"Stretched Row and Column",value:"stretchedRowAndColumn",icon:"vcv-ui-icon-attribute-row-width-stretched-content"}],containerDependency:{sidebar:"hide"}}},removeSpaces:{type:"toggle",access:"public",value:!1,options:{label:"Remove spaces",description:"Remove row spaces from left and right.",onChange:{rules:{rowWidth:{rule:"value",options:{value:"stretchedRowAndColumn"}}},actions:[{action:"toggleVisibility"}]},containerDependency:{sidebar:"removeDependencies"}}},columnGap:{type:"number",access:"public",value:"30",options:{label:"Column gap",description:"Enter gap between columns in pixels (Example: 5).",min:"0",cssMixin:{mixin:"columnGap",property:"gap",namePattern:"[\\da-f]+"}}},fullHeight:{type:"toggle",access:"public",value:!1,options:{label:"Full height",description:"Set row to be full screen height."}},metaCustomId:{type:"customId",access:"public",value:"",options:{label:"Element ID",description:"Apply unique ID to element to link directly to it by using #your_id (for element ID use lowercase input only)."}},equalHeight:{type:"toggle",access:"public",value:!1,options:{label:"Column equal height"}},columnPosition:{type:"buttonGroup",access:"public",value:"top",options:{label:"Column position",values:[{label:"Top",value:"top",icon:"vcv-ui-icon-attribute-vertical-alignment-top"},{label:"Middle",value:"middle",icon:"vcv-ui-icon-attribute-vertical-alignment-middle"},{label:"Bottom",value:"bottom",icon:"vcv-ui-icon-attribute-vertical-alignment-bottom"},{label:"Full Height",value:"stretch",icon:"vcv-ui-icon-attribute-vertical-alignment-full-height"}],onChange:{rules:{fullHeight:{rule:"toggle"}},actions:[{action:"toggleVisibility"}]}}},contentPosition:{type:"buttonGroup",access:"public",value:"top",options:{label:"Content position",values:[{label:"Top",value:"top",icon:"vcv-ui-icon-attribute-vertical-alignment-top"},{label:"Middle",value:"middle",icon:"vcv-ui-icon-attribute-vertical-alignment-middle"},{label:"Bottom",value:"bottom",icon:"vcv-ui-icon-attribute-vertical-alignment-bottom"}]}},backendView:{type:"string",access:"protected",value:"frontend"},size:{type:"string",access:"public",value:"auto"},hidden:{type:"string",access:"public",value:!1},columnBackground:{type:"string",access:"public",value:""},tag:{access:"protected",type:"string",value:"row"},sharedAssetsLibrary:{access:"protected",type:"string",value:{libraries:[{rules:{rowWidth:{rule:"!value",options:{value:"boxed"}}},libsNames:["fullWidth"]},{rules:{fullHeight:{rule:"toggle"}},libsNames:["fullHeight"]}]}},initChildren:{access:"protected",type:"object",value:[{tag:"column"}]}}}},[["./row/index.js"]]]);