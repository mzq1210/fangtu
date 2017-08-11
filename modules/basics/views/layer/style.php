<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
        &times;
    </button>
    <h4 class="modal-title" id="myModalLabel">
        设置样式
    </h4>
</div>
<form id="form_data">
    <div class="dt-hidden">
        <div class="marker-layer edit-layer-id" data-layer-type="marker_layer">
            <table class="table table-hover marker-style-normal marker-layer-select-panel">
                <tbody><tr class="layer-normal-bubble ">
                    <td class="dt-w90">
                        气泡
                        <span class="glyphicon glyphicon-info-sign colorcc style-caption" data-toggle="popover" data-container="body" data-trigger="hover" data-content="关闭气泡，水滴型的气泡不显示，图标将仅显示对应图案。" data-original-title="" title=""></span>
                    </td>
                    <td>
                        <input id="marker_has_bubble" class="chk_4" <?php if($info['bubble'] == 1) {echo 'checked="checked" value="1" ';}else{echo 'value="0"';}?> type="checkbox">
                        <label for="marker_has_bubble" class="dt-middle"></label>
                    </td>
                </tr>
                <tr class="layer-normal-color ">
                    <td class="dt-w90">
                        颜色
                        <span class="glyphicon glyphicon-info-sign colorcc style-caption" data-toggle="popover" data-container="body" data-trigger="hover" data-content="设置图标的填充颜色，有24种颜色可选。" data-original-title="" title=""></span>
                    </td>
                    <td class="style-box style-color">
                        <div class="dt-hidden" data-class-name="layer-select-color">
                            <div class="dt-pointer dt-w60 show-color-rgb">
                                <div class="sp-replacer sp-light">
                                    <div class="sp-preview">
                                        <div class="sp-preview-inner" style="background-color: <?php echo !empty($info['iconColor']) ? '#'.$info['iconColor'] : '#FF0000';?>;"></div>
                                    </div>
                                    <div class="sp-dd">▼</div>
                                </div>
                            </div>

                        </div>
                        <br/>
                        <div style="padding:0; display: none" class="col-md-4 color-rgb" >
                            <div id="picker"></div>
                        </div>
                    </td>
                </tr>
                <tr class="layer-shape">
                    <td>
                        图案
                        <span class="glyphicon glyphicon-info-sign colorcc style-caption" data-toggle="popover" data-container="body" data-trigger="hover" data-content="图标的形状图案，例如五角星、汽车等，或者自己上传的Logo、头像。" data-original-title="" title=""></span>
                    </td>
                    <td class="style-box style-shape" data-toggle="popover" data-trigger="click" data-container="body" data-content="shape" data-original-title="" title="">

                        <div class="dt-inline">
                            <ul class="list-unstyled dt-icon-base">
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';;?>>
                                      <span class="select-shape dt-pointer <?php if($info['iconName'] == 'null') echo 'active';?>"  data-symbol="null" title="无">
                                          <span class="icon num dt-f18">无</span>
                                      </span>
                                </li>

                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'circle-stroked') echo 'active';?>" data-symbol="circle-stroked" title="circle-stroked"><span class="icon circle-stroked"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'circle') echo 'active';?>" data-symbol="circle" title="circle"><span class="icon circle"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'square-stroked') echo 'active';?>" data-symbol="square-stroked" title="square-stroked"><span class="icon square-stroked"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'square') echo 'active';?>" data-symbol="square" title="square"><span class="icon square"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'triangle-stroked') echo 'active';?>" data-symbol="triangle-stroked" title="triangle-stroked"><span class="icon triangle-stroked"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'triangle') echo 'active';?>" data-symbol="triangle" title="triangle"><span class="icon triangle"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'star-stroked') echo 'active';?>" data-symbol="star-stroked" title="star-stroked"><span class="icon star-stroked"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'star') echo 'active';?>" data-symbol="star" title="star"><span class="icon star"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer" <?php if($info['iconName'] == 'cross') echo 'active';?> data-symbol="cross" title="cross"><span class="icon cross"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer" <?php if($info['iconName'] == 'marker-stroked') echo 'active';?> data-symbol="marker-stroked" title="marker-stroked"><span class="icon marker-stroked"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer" <?php if($info['iconName'] == 'marker') echo 'active';?> data-symbol="marker" title="marker"><span class="icon marker"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'religious-jewish') echo 'active';?>" data-symbol="religious-jewish" title="religious-jewish"><span class="icon religious-jewish"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'religious-christian') echo 'active';?>" data-symbol="religious-christian" title="religious-christian"><span class="icon religious-christian"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'religious-muslim') echo 'active';?>" data-symbol="religious-muslim" title="religious-muslim"><span class="icon religious-muslim"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'cemetery') echo 'active';?>" data-symbol="cemetery" title="cemetery"><span class="icon cemetery"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'rocket') echo 'active';?>" data-symbol="rocket" title="rocket"><span class="icon rocket"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'airport') echo 'active';?>" data-symbol="airport" title="airport"><span class="icon airport"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'heliport') echo 'active';?>" data-symbol="heliport" title="heliport"><span class="icon heliport"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'rail') echo 'active';?>"  data-symbol="rail" title="rail"><span class="icon rail"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'rail-metro') echo 'active';?>" data-symbol="rail-metro" title="rail-metro"><span class="icon rail-metro"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'rail-light') echo 'active';?>" data-symbol="rail-light" title="rail-light"><span class="icon rail-light"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'bus') echo 'active';?>" data-symbol="bus" title="bus"><span class="icon bus"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'fuel') echo 'active';?>" data-symbol="fuel" title="fuel"><span class="icon fuel"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'parking') echo 'active';?>" data-symbol="parking" title="parking"><span class="icon parking"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'parking-garage') echo 'active';?>" data-symbol="parking-garage" title="parking-garage"><span class="icon parking-garage"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'airfield') echo 'active';?>" data-symbol="airfield" title="airfield"><span class="icon airfield"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'roadblock') echo 'active';?>" data-symbol="roadblock" title="roadblock"><span class="icon roadblock"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'ferry') echo 'active';?>" data-symbol="ferry" title="ferry"><span class="icon ferry"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'harbor') echo 'active';?>" data-symbol="harbor" title="harbor"><span class="icon harbor"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'bicycle') echo 'active';?>" data-symbol="bicycle" title="bicycle"><span class="icon bicycle"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'park') echo 'active';?>" data-symbol="park" title="park"><span class="icon park"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'park2') echo 'active';?>" data-symbol="park2" title="park2"><span class="icon park2"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'museum') echo 'active';?>" data-symbol="museum" title="museum"><span class="icon museum"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'lodging') echo 'active';?>" data-symbol="lodging" title="lodging"><span class="icon lodging"></span></span>
                                </li>
                                <li>
                                    <span class="select-shape dt-pointer <?php if($info['iconName'] == 'monument') echo 'active';?>" data-symbol="monument" title="monument"><span class="icon monument"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'zoo') echo 'active';?>" data-symbol = "zoo" title = "zoo"><span class = "icon zoo"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'garden') echo 'active';?>" data-symbol = "garden" title = "garden"><span class = "icon garden"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'campsite') echo 'active';?>" data-symbol = "campsite" title = "campsite"><span class = "icon campsite"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'theatre') echo 'active';?>" data-symbol = "theatre" title = "theatre"><span class = "icon theatre"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'art-gallery') echo 'active';?>" data-symbol = "art-gallery" title = "art-gallery"><span class = "icon art-gallery"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'pitch') echo 'active';?>" data-symbol = "pitch" title = "pitch"><span class = "icon pitch"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'soccer') echo 'active';?>" data-symbol = "soccer" title = "soccer"><span class = "icon soccer"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'america-football') echo 'active';?>" data-symbol = "america-football" title = "america-football"><span class = "icon america-football"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'tennis') echo 'active';?>" data-symbol = "tennis" title = "tennis"><span class = "icon tennis"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'basketball') echo 'active';?>" data-symbol = "basketball" title = "basketball"><span class = "icon basketball"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'baseball') echo 'active';?>" data-symbol = "baseball" title = "baseball"><span class = "icon baseball"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'golf') echo 'active';?>" data-symbol = "golf" title = "golf"><span class = "icon golf"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'swimming') echo 'active';?>" data-symbol = "swimming" title = "swimming"><span class = "icon swimming"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'cricket') echo 'active';?>" data-symbol = "cricket" title = "cricket"><span class = "icon cricket"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'skiing') echo 'active';?>" data-symbol = "skiing" title = "skiing"><span class = "icon skiing"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'school') echo 'active';?>" data-symbol = "school" title = "school"><span class = "icon school"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'college') echo 'active';?>" data-symbol = "college" title = "college"><span class = "icon college"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'library') echo 'active';?>" data-symbol = "library" title = "library"><span class = "icon library"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'post') echo 'active';?>" data-symbol = "post" title = "post"><span class = "icon post"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'fire-station') echo 'active';?>" data-symbol = "fire-station" title = "fire-station"><span class = "icon fire-station"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'town-hall') echo 'active';?>" data-symbol = "town-hall" title = "town-hall"><span class = "icon town-hall"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'police') echo 'active';?>" data-symbol = "police" title = "police"><span class = "icon police"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'prison') echo 'active';?>" data-symbol = "prison" title = "prison"><span class = "icon prison"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'embassy') echo 'active';?>" data-symbol = "embassy" title = "embassy"><span class = "icon embassy"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'beer') echo 'active';?>" data-symbol = "beer" title = "beer"><span class = "icon beer"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'restaurant') echo 'active';?>" data-symbol = "restaurant" title = "restaurant"><span class = "icon restaurant"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'cafe') echo 'active';?>" data-symbol = "cafe" title = "cafe"><span class = "icon cafe"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'shop') echo 'active';?>" data-symbol = "shop" title = "shop"><span class = "icon shop"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'fast-food') echo 'active';?>" data-symbol = "fast-food" title = "fast-food"><span class = "icon fast-food"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'bar') echo 'active';?>" data-symbol = "bar" title = "bar"><span class = "icon bar"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'bank') echo 'active';?>" data-symbol = "bank" title = "bank"><span class = "icon bank"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'grocery') echo 'active';?>" data-symbol = "grocery" title = "grocery"><span class = "icon grocery"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'cinema') echo 'active';?>" data-symbol = "cinema" title = "cinema"><span class = "icon cinema"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'pharmacy') echo 'active';?>" data-symbol = "pharmacy" title = "pharmacy"><span class = "icon pharmacy"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'hospital') echo 'active';?>" data-symbol = "hospital" title = "hospital"><span class = "icon hospital"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'danger') echo 'active';?>" data-symbol = "danger" title = "danger"><span class = "icon danger"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'industrial') echo 'active';?>" data-symbol = "industrial" title = "industrial"><span class = "icon industrial"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'warehouse') echo 'active';?>" data-symbol = "warehouse" title = "warehouse"><span class = "icon warehouse"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'commercial') echo 'active';?>" data-symbol = "commercial" title = "commercial"><span class = "icon commercial"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'building') echo 'active';?>" data-symbol = "building" title = "building"><span class = "icon building"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'place-of-worship') echo 'active';?>" data-symbol = "place-of-worship" title = "place-of-worship"><span class = "icon place-of-worship"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'alcohol-shop') echo 'active';?>" data-symbol = "alcohol-shop" title = "alcohol-shop"><span class = "icon alcohol-shop"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'logging') echo 'active';?>" data-symbol = "logging" title = "logging"><span class = "icon logging"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'oil-well') echo 'active';?>" data-symbol = "oil-well" title = "oil-well"><span class = "icon oil-well"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'slaughterhouse') echo 'active';?>" data-symbol = "slaughterhouse" title = "slaughterhouse"><span class = "icon slaughterhouse"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'dam') echo 'active';?>" data-symbol = "dam" title = "dam"><span class = "icon dam"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'water') echo 'active';?>" data-symbol = "water" title = "water"><span class = "icon water"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'wetland') echo 'active';?>" data-symbol = "wetland" title = "wetland"><span class = "icon wetland"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'disability') echo 'active';?>" data-symbol = "disability" title = "disability"><span class = "icon disability"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'telephone') echo 'active';?>" data-symbol = "telephone" title = "telephone"><span class = "icon telephone"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'emergency-telephone') echo 'active';?>" data-symbol = "emergency-telephone" title = "emergency-telephone"><span class = "icon emergency-telephone"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'toilets') echo 'active';?>" data-symbol = "toilets" title = "toilets"><span class = "icon toilets"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'waste-basket') echo 'active';?>" data-symbol = "waste-basket" title = "waste-basket"><span class = "icon waste-basket"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'music') echo 'active';?>" data-symbol = "music" title = "music"><span class = "icon music"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'land-use') echo 'active';?>" data-symbol = "land-use" title = "land-use"><span class = "icon land-use"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'city') echo 'active';?>" data-symbol = "city" title = "city"><span class = "icon city"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'town') echo 'active';?>" data-symbol = "town" title = "town"><span class = "icon town"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'village') echo 'active';?>" data-symbol = "village" title = "village"><span class = "icon village"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'farm') echo 'active';?>" data-symbol = "farm" title = "farm"><span class = "icon farm"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'bakery') echo 'active';?>" data-symbol = "bakery" title = "bakery"><span class = "icon bakery"></span></span>
                                </li>
                                <li>
                                    <span class = "select-shape dt-pointer" data-symbol = "dog-park" title = "dog-park"><span class = "icon dog-park"></span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '0') echo 'active';?>" data-symbol = "0" title = "0">
                                        <span class = "icon num dt-f16 ">0</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '1') echo 'active';?>" data-symbol = "1" title = "1">
                                        <span class = "icon num dt-f16 ">1</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '2') echo 'active';?>" data-symbol = "2" title = "2">
                                        <span class = "icon num dt-f16">2</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '3') echo 'active';?>" data-symbol = "3" title = "3">
                                        <span class = "icon num dt-f16 ">3</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '4') echo 'active';?>" data-symbol = "4" title = "4">
                                        <span class = "icon num dt-f16">4</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '5') echo 'active';?>" data-symbol = "5" title = "5">
                                        <span class = "icon num dt-f16">5</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '6') echo 'active';?>" data-symbol = "6" title = "6">
                                        <span class = "icon num dt-f16">6</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '7') echo 'active';?>" data-symbol = "7" title = "7">
                                        <span class = "icon num dt-f16">7</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '8') echo 'active';?>" data-symbol = "8" title = "8">
                                        <span class = "icon num dt-f16">8</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == '9') echo 'active';?>" data-symbol = "9" title = "9">
                                        <span class = "icon num dt-f16">9</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'a') echo 'active';?>" data-symbol = "a" title = "a">
                                        <span class = "icon num dt-f16">a</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'b') echo 'active';?>" data-symbol = "b" title = "b">
                                        <span class = "icon num dt-f16">b</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'c') echo 'active';?>" data-symbol = "c" title = "c">
                                        <span class = "icon num dt-f16">c</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'd') echo 'active';?>" data-symbol = "d" title = "d">
                                        <span class = "icon num dt-f16">d</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'e') echo 'active';?>" data-symbol = "e" title = "e">
                                        <span class = "icon num dt-f16">e</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'f') echo 'active';?>" data-symbol = "f" title = "f">
                                        <span class = "icon num dt-f16">f</span>
                                    </span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'g') echo 'active';?>" data-symbol = "g" title = "g"><span class = "icon num dt-f16">g</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'h') echo 'active';?>" data-symbol = "h" title = "h"><span class = "icon num dt-f16">h</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'i') echo 'active';?>" data-symbol = "i" title = "i"><span class = "icon num dt-f16">i</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'j') echo 'active';?>" data-symbol = "j" title = "j"><span class = "icon num dt-f16">j</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'k') echo 'active';?>" data-symbol = "k" title = "k"><span class = "icon num dt-f16">k</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'l') echo 'active';?>" data-symbol = "l" title = "l"><span class = "icon num dt-f16">l</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'm') echo 'active';?>" data-symbol = "m" title = "m"><span class = "icon num dt-f16">m</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'n') echo 'active';?>" data-symbol = "n" title = "n"><span class = "icon num dt-f16">n</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'o') echo 'active';?>" data-symbol = "o" title = "o"><span class = "icon num dt-f16">o</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'p') echo 'active';?>" data-symbol = "p" title = "p"><span class = "icon num dt-f16">p</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'q') echo 'active';?>" data-symbol = "q" title = "q"><span class = "icon num dt-f16">q</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none";';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'r') echo 'active';?>" data-symbol = "r" title = "r"><span class = "icon num dt-f16">r</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none";';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 's') echo 'active';?>" data-symbol = "s" title = "s"><span class = "icon num dt-f16">s</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 't') echo 'active';?>" data-symbol = "t" title = "t"><span class = "icon num dt-f16">t</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'u') echo 'active';?>" data-symbol = "u" title = "u"><span class = "icon num dt-f16">u</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'v') echo 'active';?>" data-symbol = "v" title = "v"><span class = "icon num dt-f16">v</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'w') echo 'active';?>" data-symbol = "w" title = "w"><span class = "icon num dt-f16">w</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'x') echo 'active';?>" data-symbol = "x" title = "x"><span class = "icon num dt-f16">x</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'y') echo 'active';?>" data-symbol = "y" title = "y"><span class = "icon num dt-f16">y</span></span>
                                </li>
                                <li class="black" <?php if($info['bubble'] != 1) echo 'style="display:none"';?>>
                                    <span class = "select-shape dt-pointer <?php if($info['iconName'] == 'z') echo 'active';?>" data-symbol = "z" title = "z"><span class = "icon num dt-f16">z</span></span>
                                </li>
                            </ul>

                        </div>
                    </td>
                </tr>
                <tr class="layer-size-setting ">
                    <td>尺寸</td>
                    <td>
                        <div class="btn-group marker-normal-size dt-w90 btn-group-xs btn-group-justified" role="group">
                            <a type="button" class="btn btn-default <?php if($info['size'] == 's') echo 'active';?>" data-size="s">小</a>
                            <a type="button" class="btn btn-default <?php if($info['size'] == 'm') echo 'active';?>" data-size="m">中</a>
                            <a type="button" class="btn btn-default <?php if($info['size'] == 'l') echo 'active';?>" data-size="l">大</a>
                        </div>
                    </td>
                </tr>
                <tr class="layer-label-fields">
                    <td>
                        标签字段
                        <span class="glyphicon glyphicon-info-sign colorcc style-caption" data-toggle="popover" data-container="body" data-trigger="hover" data-content="做为标签的字段，字段的内容将以标签的形式显示在图标旁边。例如将标注名称显示在地图上，就可以选择名称字段做为标签。" data-original-title="" title=""></span>
                    </td>
                    <td class="dt-pos-r style-box layer-label" data-toggle="popover" data-trigger="click" data-container="body" data-content="label" data-original-title="" title="">
                        <div id="styleShowTitle" role="group" class="btn-group  btn-group-xs btn-group-justified">
                            <a data-size="0" class="btn btn-default <?php if(empty($info['lable'])) echo 'active';?>" type="button">无</a>
                            <?php foreach ($lable as $k => $v): ?>
                            <a data-size="<?php echo $k;?>" class="btn btn-default <?php echo ($info['lable'] == $k) ? 'active' : '';?>" type="button" ><?php echo $v;?></a>
                            <?php endforeach;?>
                        </div>
                    </td>
                </tr>
                <tr class="layer-label-fields">
                    <td>
                        预览图标
                    </td>
                    <td class="" >
                        <div style="display: block; height: 68px; width: 156px; line-height: 66px; text-align: left; ">
                            <img bubble="true"  src="/icons/default/<?php echo $info['ico'];?>" class="icon_preview">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-default" type="button" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary site-layer-style">提交</button>
    </div>
</form>

<script type="text/javascript">
    $(function(){


        //设置有无气泡
        $('#marker_has_bubble').click(function(){
            var bubble = $('#marker_has_bubble').val();
            if(bubble == 0){
                $('.dt-icon-base .black').show();
                $('#marker_has_bubble').val('1');
                $('#marker_has_bubble').attr('checked','checked');
                createImageLabel();
            }else{
                $('#marker_has_bubble').val('0');
                $('#marker_has_bubble').removeAttr('checked');
                $('.dt-icon-base .black').hide();
                $('.dt-icon-base .black .select-shape').removeClass('active');
                var is_symbol = $('.dt-icon-base .active').attr('data-symbol');
                if(!is_symbol){
                    $(".dt-icon-base li:nth-child(2) .select-shape").addClass("active");
                }

                createImageLabel();
            }
        });
        //调取颜色模板
        $('#picker').colpick({
            flat:true,
            layout:'hex',
            submit:1,
            color:'<?php echo $info['iconColor'];?>',
            onChange:function() {
                var color = $(".colpick_hex_field input").val();
                $('.sp-preview-inner').css('background-color','#'+color);
                createImageLabel()
            }
        });

        $('.colpick_submit').on('click', function(){
            $('.color-rgb').hide();
        })
        //设置标签字段
        $('#styleShowTitle a').on('click', function(){
            $(this).addClass("active").siblings().removeClass('active');
            var data_size = $(this).attr("data-size");
            $('#lable').val(data_size);
        });
        //设置尺寸
        $('.marker-normal-size a').on('click', function(){
            $(this).addClass("active").siblings().removeClass('active');
            var data_size = $(this).attr("data-size");
            $('#size').val(data_size);
            createImageLabel();
        });
        //设置图案
        $(".list-unstyled .select-shape").click( function (e) {
            $(".select-shape").removeClass("active");
            $(this).addClass("active");
            createImageLabel();
        });
        //异步生成图标
        function createImageLabel() {
            var color = $(".colpick_hex_field input").val();
            var size = $(".marker-normal-size .active").attr("data-size");
            var symbol = $(".dt-icon-base .active").attr("data-symbol");
            var bubble = $('#marker_has_bubble').val();
            if(bubble == 0 && symbol == 'null'){
                symbol = $(".dt-icon-base li:nth-child(2) span").attr("data-symbol");
                $(".dt-icon-base li:nth-child(2) .select-shape").addClass("active");
                $(".dt-icon-base li:nth-child(1) .select-shape").removeClass("active");
            }
            var url = '/basics/layer/createimg_ajax';
            $.post(url,{'color':color,'size':size,'symbol':symbol,'bubble':bubble},function(data){
                var info = JSON.parse(data);
                if(info.code == 200){
                    $(".icon_preview").attr('src','/icons/default/'+info.data.imgName);
                }else{
                    toastr.error("添加失败!");
                }
            });
        }

        //提交设置图层样式
        $('.site-layer-style').click(function(){
            var bubble =$('#marker_has_bubble').val();
            var color = $(".colpick_hex_field input").val();
            var size = $(".marker-normal-size .active").attr("data-size");
            var symbol = $(".select-shape.active").attr("data-symbol");
            var lable = $('#styleShowTitle .active').attr('data-size');
            var id = <?php echo $id;?>;
            var url = '/basics/layer/setstyle_ajax';
            $.post(url,{'bubble':bubble, 'color':color, 'size':size, 'symbol':symbol, 'lable':lable,'id':id},function(data){
                var info = JSON.parse(data);
                if(info.code == 200){
                    $('#setLayerStyle').modal("hide");
                    toastr.success("设置成功");
                    $('#icon_'+id).css("background-image","url("+info.data.ico+")");
                    if(info.data.marker == 2){
                        $('#icon_'+id).css("background-size","");
                    }else{
                        $('#icon_'+id).css("background-size","18px 18px");
                    }
                    updateIco(id, info.data);
                }else{
                    toastr.error("设置失败!");
                }
                $('#styleModal').modal('hide');
            });
        });
        //数据视图模态框关闭时清除缓存
        $("#styleModal").on("hidden.bs.modal", function () {
            $(this).removeData("bs.modal");
        });
        $('.show-color-rgb').on('click', function(){
            $('.color-rgb').show();
        })
    })


</script>

