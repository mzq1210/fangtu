<?php

/*
 * 分页插件
 * 调用方法
 * @author <liangpingzheng>
 * @date Nov 29, 2016 1:50:14 PM
 */

namespace app\common\widgets;

use yii\widgets\LinkPager;
use yii\helpers\Html;
use Yii;

class GoLinkPager extends LinkPager {

    public $pageSizeOptions = [
        'id' => 'perpage',
        'class' => 'form-control2',
        'style' => [
            'display' => 'inline-block',
            'width' => '50px',
            'line-height' => '20px',
            'margin-top' => '0px',
        ],
    ];
    public $pageSizeList = [10, 15, 20, 25, 30, 50,100];
    // 是否包含跳转功能跳转 默认false
    public $go = true;

    protected function renderPageButtons() {
        $this->options = ['class'=>'pagination','style'=>['margin'=>'0px']];//设置分页样式类
        
        $pageCount = $this->pagination->getPageCount();
//        if ($pageCount < 2 && $this->hideOnSinglePage) {
//            return '';
//        }
        $buttons = [];
        $currentPage = $this->pagination->getPage();
        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }
        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }
        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }
        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }
        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        //自定义每页显示条数
        $pageSizeList = [];
        foreach ($this->pageSizeList as $value) {
            $pageSizeList[$value] = $value;
        }
        $customPage = Html::dropDownList($this->pagination->pageSizeParam, $this->pagination->getPageSize(), $pageSizeList, $this->pageSizeOptions);

        // go
        if ($this->go) {
            $goPage = $currentPage + 1;
            $goHtml = <<<goHtml
                <div class="" style="float: left; color: #999; margin-left: 10px; font-size: 12px;">
                    <span class="text">共 {$pageCount} 页, {$this->pagination->totalCount} 条</span>
                    <span class="text">到第</span>
                    <input class="form-control" id='gopage' type="text" value="{$goPage}" min="1" max="{$pageCount}" aria-label="页码输入框" style="height:28px;width:35px;display:inline">
                    <span class="text">页</span>
                   <span class="btn btn-default go-page" role="button" style="padding:3px;height:28px;" tabindex="0" >GO</span>
                    &nbsp;&nbsp每页显示{$customPage}
                </div>  
goHtml;
            $buttons[] = $goHtml;
            $pageLink = $this->pagination->createUrl(0, 5, true);
            $goJs = <<<goJs
                 $('.go-page').click(function(){
                    pager();
                });
                
                $("#perpage").change(function (){ 
                    pager();
                });

                function pager(){
                    customPage = $("#perpage").val();
                    goPage = $("#gopage").val();
                    pageLink = "{$pageLink}";
                    pageLink = pageLink.replace("page=1", "page="+goPage);
                    pageLink = pageLink.replace("per-page=5", "per-page="+customPage); 
                    if (goPage >= 1 && goPage <= {$pageCount}) {
                        window.location.href=pageLink;
                    } else {
                        $("#gopage").focus();
                    }
                }
goJs;
            $this->view->registerJs($goJs);
        }
        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }

}
