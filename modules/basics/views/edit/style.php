
<div class = "modal-header">
    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
        <span class = "dt-f22" aria-hidden = "true">×</span></button>
    <h5 class = "modal-title" id = "myModalLabel">标注样式设置</h5>
</div>
<div class = "modal-body marker-icon-style">
    <div class = "col-md-4" style = "padding:0">
        <style>
            .select-color {
                height: 20px;
                width: 20px;
                margin:2px;
                border-radius: 4px;
                float: left;
                border: 1px solid #ccc;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }
            .boximg{
                display: table-cell;
                vertical-align: middle;
                text-align: center;
                height: 68px;
                width: 156px;
                border: 1px solid #ccc;
            }
            .boximg img{
                vertical-align: middle;
            }
        </style>
        <div class = "dt-hidden color-picker">
            <div class = "select-color dt-pointer active" data-color = "f1f075" style = "background-color:#f1f075;"></div>
            <div class = "select-color dt-pointer" data-color = "eaf7ca" style = "background-color:#eaf7ca;"></div>
            <div class = "select-color dt-pointer" data-color = "c5e96f" style = "background-color:#c5e96f;"></div>
            <div class = "select-color dt-pointer" data-color = "a3e46b" style = "background-color:#a3e46b;"></div>
            <div class = "select-color dt-pointer" data-color = "7ec9b1" style = "background-color:#7ec9b1;"></div>
            <div class = "select-color dt-pointer" data-color = "b7ddf3" style = "background-color:#b7ddf3;"></div>

            <div class = "select-color dt-pointer" data-color = "63b6e5" style = "background-color:#63b6e5;"></div>
            <div class = "select-color dt-pointer" data-color = "3ca0d3" style = "background-color:#3ca0d3;"></div>
            <div class = "select-color dt-pointer" data-color = "1087bf" style = "background-color:#1087bf;"></div>
            <div class = "select-color dt-pointer" data-color = "548cba" style = "background-color:#548cba;"></div>
            <div class = "select-color dt-pointer" data-color = "677da7" style = "background-color:#677da7;"></div>
            <div class = "select-color dt-pointer" data-color = "9c89cc" style = "background-color:#9c89cc;"></div>

            <div class = "select-color dt-pointer" data-color = "c091e6" style = "background-color:#c091e6;"></div>
            <div class = "select-color dt-pointer" data-color = "d27591" style = "background-color:#d27591;"></div>
            <div class = "select-color dt-pointer" data-color = "f86767" style = "background-color:#f86767;"></div>
            <div class = "select-color dt-pointer" data-color = "e7857f" style = "background-color:#e7857f;"></div>
            <div class = "select-color dt-pointer" data-color = "fa946e" style = "background-color:#fa946e;"></div>
            <div class = "select-color dt-pointer" data-color = "f5c272" style = "background-color:#f5c272;"></div>

            <div class = "select-color dt-pointer" data-color = "ede8e4" style = "background-color:#ede8e4;"></div>
            <div class = "select-color dt-pointer" data-color = "ffffff" style = "background-color:#ffffff;"></div>
            <div class = "select-color dt-pointer" data-color = "cccccc" style = "background-color:#cccccc;"></div>
            <div class = "select-color dt-pointer" data-color = "6c6c6c" style = "background-color:#6c6c6c;"></div>
            <div class = "select-color dt-pointer" data-color = "1f1f1f" style = "background-color:#1f1f1f;"></div>
            <div class = "select-color dt-pointer" data-color = "000000" style = "background-color:#000000;"></div>

        </div>
    </div>
    <div class = "col-md-4 dt-pad46l">
        <div class = "dt-line-34h dt-hidden marker-icon-size">
            <label for = "marker_set_has_bubble" class = "pull-left dt-mar2l">
                <input type = "radio" id = "marker_set_has_bubble" class = "has-bubble" name = "radio_marker_bubble" checked = "">
                有气泡
            </label>
            <label for = "marker_set_not_bubble" class = "pull-right">
                <input type = "radio" id = "marker_set_not_bubble" class = "not-bubble" name = "radio_marker_bubble">
                无气泡
            </label>
        </div>
        <div class = "marker-icon-size text-center dt-line-34h dt-hidden">
            <label for = "marker_small_icon" class = "pull-left dt-mar2l">
                <input type = "radio" id = "marker_small_icon" name = "marker_icon_size_radio" data-size = "s" checked = "">
                小
            </label>
            <label for = "marker_middle_icon">
                <input type = "radio" id = "marker_middle_icon" name = "marker_icon_size_radio" data-size = "m">
                中
            </label>
            <label for = "marker_large_icon" class = "pull-right">
                <input type = "radio" id = "marker_large_icon" name = "marker_icon_size_radio" data-size = "l">
                大
            </label>
        </div>
    </div>

    <div class = "col-md-4" style = "padding:0;padding-left: 36px;">
        <div class="boximg">
            <img  class = "icon_preview" src = "/icons/default/<?php echo $data['icon']; ?>" layoutid="<?php echo $data['id']; ?>" icon="<?php echo $data['icon']; ?>" color = "<?php echo $data['color']; ?>" size = "<?php echo $data['size']; ?>" symbol = "<?php echo $data['symbol']; ?>" bubble = "<?php echo $data['bubble']; ?>">
        </div>
    </div>

    <div class = "dt-pad12y dt-inline">
        <ul class = "list-unstyled dt-icon-base">
            <li>
                <span class = "select-shape dt-pointer black" data-symbol = "null" title = "无">
                    <span class = "icon num dt-f18">无</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "circle-stroked" title = "circle-stroked"><span class = "icon circle-stroked"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "circle" title = "circle"><span class = "icon circle"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "square-stroked" title = "square-stroked"><span class = "icon square-stroked"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "square" title = "square"><span class = "icon square"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "triangle-stroked" title = "triangle-stroked"><span class = "icon triangle-stroked"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "triangle" title = "triangle"><span class = "icon triangle"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "star-stroked" title = "star-stroked"><span class = "icon star-stroked"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "star" title = "star"><span class = "icon star"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "cross" title = "cross"><span class = "icon cross"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "marker-stroked" title = "marker-stroked"><span class = "icon marker-stroked"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "marker" title = "marker"><span class = "icon marker"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "religious-jewish" title = "religious-jewish"><span class = "icon religious-jewish"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "religious-christian" title = "religious-christian"><span class = "icon religious-christian"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "religious-muslim" title = "religious-muslim"><span class = "icon religious-muslim"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "cemetery" title = "cemetery"><span class = "icon cemetery"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "rocket" title = "rocket"><span class = "icon rocket"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "airport" title = "airport"><span class = "icon airport"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "heliport" title = "heliport"><span class = "icon heliport"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "rail" title = "rail"><span class = "icon rail"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "rail-metro" title = "rail-metro"><span class = "icon rail-metro"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "rail-light" title = "rail-light"><span class = "icon rail-light"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "bus" title = "bus"><span class = "icon bus"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "fuel" title = "fuel"><span class = "icon fuel"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "parking" title = "parking"><span class = "icon parking"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "parking-garage" title = "parking-garage"><span class = "icon parking-garage"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "airfield" title = "airfield"><span class = "icon airfield"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "roadblock" title = "roadblock"><span class = "icon roadblock"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "ferry" title = "ferry"><span class = "icon ferry"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "harbor" title = "harbor"><span class = "icon harbor"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "bicycle" title = "bicycle"><span class = "icon bicycle"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "park" title = "park"><span class = "icon park"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "park2" title = "park2"><span class = "icon park2"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "museum" title = "museum"><span class = "icon museum"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "lodging" title = "lodging"><span class = "icon lodging"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "monument" title = "monument"><span class = "icon monument"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "zoo" title = "zoo"><span class = "icon zoo"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "garden" title = "garden"><span class = "icon garden"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "campsite" title = "campsite"><span class = "icon campsite"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "theatre" title = "theatre"><span class = "icon theatre"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "art-gallery" title = "art-gallery"><span class = "icon art-gallery"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "pitch" title = "pitch"><span class = "icon pitch"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "soccer" title = "soccer"><span class = "icon soccer"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "america-football" title = "america-football"><span class = "icon america-football"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "tennis" title = "tennis"><span class = "icon tennis"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "basketball" title = "basketball"><span class = "icon basketball"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "baseball" title = "baseball"><span class = "icon baseball"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "golf" title = "golf"><span class = "icon golf"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "swimming" title = "swimming"><span class = "icon swimming"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "cricket" title = "cricket"><span class = "icon cricket"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "skiing" title = "skiing"><span class = "icon skiing"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "school" title = "school"><span class = "icon school"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "college" title = "college"><span class = "icon college"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "library" title = "library"><span class = "icon library"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "post" title = "post"><span class = "icon post"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "fire-station" title = "fire-station"><span class = "icon fire-station"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "town-hall" title = "town-hall"><span class = "icon town-hall"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "police" title = "police"><span class = "icon police"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "prison" title = "prison"><span class = "icon prison"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "embassy" title = "embassy"><span class = "icon embassy"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "beer" title = "beer"><span class = "icon beer"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "restaurant" title = "restaurant"><span class = "icon restaurant"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "cafe" title = "cafe"><span class = "icon cafe"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "shop" title = "shop"><span class = "icon shop"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "fast-food" title = "fast-food"><span class = "icon fast-food"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "bar" title = "bar"><span class = "icon bar"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "bank" title = "bank"><span class = "icon bank"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "grocery" title = "grocery"><span class = "icon grocery"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "cinema" title = "cinema"><span class = "icon cinema"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "pharmacy" title = "pharmacy"><span class = "icon pharmacy"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "hospital" title = "hospital"><span class = "icon hospital"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "danger" title = "danger"><span class = "icon danger"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "industrial" title = "industrial"><span class = "icon industrial"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "warehouse" title = "warehouse"><span class = "icon warehouse"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "commercial" title = "commercial"><span class = "icon commercial"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "building" title = "building"><span class = "icon building"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "place-of-worship" title = "place-of-worship"><span class = "icon place-of-worship"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "alcohol-shop" title = "alcohol-shop"><span class = "icon alcohol-shop"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "logging" title = "logging"><span class = "icon logging"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "oil-well" title = "oil-well"><span class = "icon oil-well"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "slaughterhouse" title = "slaughterhouse"><span class = "icon slaughterhouse"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "dam" title = "dam"><span class = "icon dam"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "water" title = "water"><span class = "icon water"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "wetland" title = "wetland"><span class = "icon wetland"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "disability" title = "disability"><span class = "icon disability"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "telephone" title = "telephone"><span class = "icon telephone"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "emergency-telephone" title = "emergency-telephone"><span class = "icon emergency-telephone"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "toilets" title = "toilets"><span class = "icon toilets"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "waste-basket" title = "waste-basket"><span class = "icon waste-basket"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "music" title = "music"><span class = "icon music"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "land-use" title = "land-use"><span class = "icon land-use"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "city" title = "city"><span class = "icon city"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "town" title = "town"><span class = "icon town"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "village" title = "village"><span class = "icon village"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "farm" title = "farm"><span class = "icon farm"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "bakery" title = "bakery"><span class = "icon bakery"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "dog-park" title = "dog-park"><span class = "icon dog-park"></span></span>
            </li>
            <!--<li>
                <span class = "select-shape dt-pointer" data-symbol = "lighthouse" title = "lighthouse"><span class = "icon lighthouse"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "clothing-store" title = "clothing-store"><span class = "icon clothing-store"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "polling-place" title = "polling-place"><span class = "icon polling-place"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "playground" title = "playground"><span class = "icon playground"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "entrance" title = "entrance"><span class = "icon entrance"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "heart" title = "heart"><span class = "icon heart"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "camera" title = "camera"><span class = "icon camera"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "laundry" title = "laundry"><span class = "icon laundry"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "car" title = "car"><span class = "icon car"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "suitcase" title = "suitcase"><span class = "icon suitcase"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "hairdresser" title = "hairdresser"><span class = "icon hairdresser"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "chemist" title = "chemist"><span class = "icon chemist"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "mobilephone" title = "mobilephone"><span class = "icon mobilephone"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "scooter" title = "scooter"><span class = "icon scooter"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "gift" title = "gift"><span class = "icon gift"></span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer" data-symbol = "ice-cream" title = "ice-cream"><span class = "icon ice-cream"></span></span>
            </li>-->


            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "0" title = "0">
                    <span class = "icon num dt-f16 ">0</span>
                </span>
            </li><li>
                <span class = "select-shape dt-pointer  black" data-symbol = "1" title = "1">
                    <span class = "icon num dt-f16 ">1</span>
                </span>
            </li><li>
                <span class = "select-shape dt-pointer  black" data-symbol = "2" title = "2">
                    <span class = "icon num dt-f16">2</span>
                </span>
            </li><li>
                <span class = "select-shape dt-pointer  black" data-symbol = "3" title = "3">
                    <span class = "icon num dt-f16 ">3</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "4" title = "4">
                    <span class = "icon num dt-f16">4</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "5" title = "5">
                    <span class = "icon num dt-f16">5</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "6" title = "6">
                    <span class = "icon num dt-f16">6</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "7" title = "7">
                    <span class = "icon num dt-f16">7</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "8" title = "8">
                    <span class = "icon num dt-f16">8</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "9" title = "9">
                    <span class = "icon num dt-f16">9</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "a" title = "a">
                    <span class = "icon num dt-f16">a</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "b" title = "b">
                    <span class = "icon num dt-f16">b</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "c" title = "c">
                    <span class = "icon num dt-f16">c</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "d" title = "d">
                    <span class = "icon num dt-f16">d</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "e" title = "e">
                    <span class = "icon num dt-f16">e</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "f" title = "f">
                    <span class = "icon num dt-f16">f</span>
                </span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "g" title = "g"><span class = "icon num dt-f16">g</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "h" title = "h"><span class = "icon num dt-f16">h</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "i" title = "i"><span class = "icon num dt-f16">i</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "j" title = "j"><span class = "icon num dt-f16">j</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "k" title = "k"><span class = "icon num dt-f16">k</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "l" title = "l"><span class = "icon num dt-f16">l</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "m" title = "m"><span class = "icon num dt-f16">m</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "n" title = "n"><span class = "icon num dt-f16">n</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "o" title = "o"><span class = "icon num dt-f16">o</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "p" title = "p"><span class = "icon num dt-f16">p</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "q" title = "q"><span class = "icon num dt-f16">q</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "r" title = "r"><span class = "icon num dt-f16">r</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "s" title = "s"><span class = "icon num dt-f16">s</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "t" title = "t"><span class = "icon num dt-f16">t</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "u" title = "u"><span class = "icon num dt-f16">u</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "v" title = "v"><span class = "icon num dt-f16">v</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "w" title = "w"><span class = "icon num dt-f16">w</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "x" title = "x"><span class = "icon num dt-f16">x</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "y" title = "y"><span class = "icon num dt-f16">y</span></span>
            </li>
            <li>
                <span class = "select-shape dt-pointer  black" data-symbol = "z" title = "z"><span class = "icon num dt-f16">z</span></span>
            </li>
        </ul>
    </div>
    <!--
                    <span>自定义图标</span>
                    <br>
                    <span class = "dt-show">1.只支持png、jpg、jpeg、gif格式;2.最大5M，最大显示100x100</span>
    
                    <div id = "uploadifive-upload_icon2" class = "uploadifive-button upload-custom-img pull-left" style = "height: 46px; overflow: hidden; position: relative; text-align: center; width: 46px;">+<div id = "upload_icon2" class = "upload_icon" style = "display: none;"></div><input type = "file" style = "font-size: 46px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;" accept = "image/*"></div><div id = "uploadifive-upload_icon2-queue" class = "uploadifive-queue"></div>
                    <div class = "container-fluid">
                        <div class = "custom_icons" style = "max-height: 180px; overflow: auto;">
    
                        </div>
                    </div>
    -->
</div>
<div class = "modal-footer">
    <button type = "button" class = "btn btn-default" data-dismiss = "modal">取消</button>
    <button type = "button" class = "btn btn-primary" data-dismiss = "modal" id = "set_single_icon">应用</button>
</div>

<script>
    $(function () {
        $(".marker-icon-style .select-color").bind("click", function () {
            $(".select-color").removeClass("active"), $(this).addClass("active"), g()
        });
        $(".marker-icon-style .select-shape").bind("click", function () {
            $(".select-shape").removeClass("active"), $(this).addClass("active"), g()
        });
        $("input[name='marker_icon_size_radio']").click(function () {
            $(this).addClass("active"), g()
        });
        $("input[name='radio_bubble'], input[name='radio_category_bubble'], input[name='radio_marker_bubble']").click(function (t) {
            $(".select-shape").removeClass("active"), $(".icon_size").removeClass("active"), $(".select-color").removeClass("active"), $("[data-color='f86767']").addClass("active");
            var e = "";
            "not_bubble" == $(t.target).attr("id") || "category_not_bubble" == $(t.target).attr("id") || "marker_set_not_bubble" == $(t.target).attr("id") ? ($(".icon.num").closest("li").hide(), $("[data-size='l']").addClass("active"), $("[data-symbol='embassy']").addClass("active")) : ($(".icon.num").closest("li").show(), $("[data-size='s']").addClass("active"), $("[data-symbol='null']").addClass("active")), g()
        });
        function g() {
            var t = $(".select-color.active").attr("data-color"),
                    e = "";
            if ("block" == $("#myModalLayerStyle").css("display"))
                var i = $("input[name='icon_size_radio']");
            else
                var i = $("input[name='marker_icon_size_radio']");
            for (var n = 0; n < i.length; n++)
                $(i[n]).is(":checked") && (e = $(i[n]).attr("data-size"));
            var r = $(".select-shape.active").attr("data-symbol");
            "undefined" == typeof r && (r = "null");
            var a, o;
            a = "false" == $("#editCategoryMarkerIcon").attr("aria-hidden") ? $("#editCategoryMarkerIcon").find(".has-bubble").is(":checked") : $(".in").find(".has-bubble").is(":checked");
            console.log(a);
            var url = '/basics/layer/createimg_ajax';
            $.post(url, {'bubble': a, 'color': t, 'size': e, 'symbol': r}, function (data) {
                var info = JSON.parse(data);
                if (info.code == 200) {
                    o = "/icons/default/" + info.data.imgName;
                    $(".icon_preview").attr('icon', info.data.imgName).attr("color", t).attr("size", e).attr("symbol", r).attr("bubble", a).attr("src", o);
//                    toastr.success("设置成功");
                } else {
//                    toastr.error("设置失败!");
                }
//                $('#storeStyleModal').modal('hide');
            });
        }
        ;

//        ajax提交设置
        $("#set_single_icon").unbind().click(function () {

            n = $(".icon_preview").attr("size");
            layoutid = $(".icon_preview").attr("layoutid");
            size = $(".icon_preview").attr("size");

            img = $(".icon_preview").attr("icon");
            $.post('/basics/edit/setstyle_ajax', {'icon': img, 'id': layoutid,'size':size}, function (data) {
                var info = JSON.parse(data);
                if (info.code == 200) {
                    $('#setLayerStyle').modal("hide");
                    toastr.success("设置成功");
                    updateStoreIco(layoutid, '/icons/default/' + img, n);
                } else {
                    toastr.error("设置失败!");
                }
                $('#storeStyleModal').modal('hide');
            });



        });
    });
</script>