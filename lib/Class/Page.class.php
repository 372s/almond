<?php

/**
 * 分页
 */
class Page
{
    protected $_totalNumber;
    protected $_perPage = 10;
    protected $_currentPage;
    protected $_maxPage;
    protected $_pageSlice;

    public function __construct($totalNumber, $perPage = 0, $currentPage = 0) {


		if ($currentPage == false) {
            if (empty($_GET['page'])) {
                $currentPage = 1;
            } else {
                $currentPage = $_GET["page"] < 1 ? 1 : $_GET["page"];
            }
        }

        if ($perPage == false) {
            $perPage = $this->_perPage;
        } else if ($perPage < 1) {
            $perPage = $this->_perPage;
        }

        $maxPage = ceil($totalNumber < 1 ? 1 : $totalNumber / $perPage);

        if ($currentPage > $maxPage) {
            $currentPage = $maxPage;
        }

		$this->_totalNumber     = $totalNumber;
		$this->_perPage         = $perPage;
		$this->_maxPage         = $maxPage;
		$this->_currentPage     = $currentPage;
	}

    public function slice($iOffset = 2, $iBorder = 1) {

        $iKeep = $iOffset + $iBorder;
        $iPageMax = $this->_maxPage;

        $aBegin = array();
        if ($this->_currentPage < $iKeep) {
            $aBegin = range(0, $iKeep + $iOffset);
        } else if ($iBorder > 0) {
            $aBegin = range(0, $iBorder - 1);
        }
        $aEnd = array();
        if ($this->_currentPage > ($iPageMax - $iKeep)) {
            $aEnd = range($iPageMax - $iKeep - $iOffset, $iPageMax);
        } else if ($iBorder > 0) {
            $aEnd = range($iPageMax - $iBorder + 1, $iPageMax);
        }

        $aBody = range($this->_currentPage - $iOffset, $this->_currentPage + $iOffset);
        $aSlice = array_merge($aBegin, $aEnd, $aBody);
        $aSlice = array_unique($aSlice);
        $aSlice = array_filter($aSlice, function($iPage) use ($iPageMax) {
            if ($iPage < 0) {
                return FALSE;
            }
            if ($iPage > $iPageMax) {
                return FALSE;
            }
            return TRUE;
        });

        sort($aSlice);
        $this->_pageSlice = $aSlice;

        return $aSlice;
    }

    public function encodeURI($url) {
        // return "javascript:window.location=encodeURI('".htmlEncode(URLStatic::parse_url($url))."')";
        // http://php.net/manual/en/function.rawurlencode.php
        // https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/encodeURI
        $reserved = array(
            '%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!',
            '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'
        );
        $unescaped = array(
            '%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',
            '%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'
        );
        $score = array(
            '%23'=>'#'
        );
        return strtr(rawurlencode($url), array_merge($reserved,$unescaped,$score));
    }

    //分页
	public function getHTML($aTpl = array()) {
		if (is_string($aTpl)) {
			$aTpl = array("href" => $aTpl);
		}

		//页码：
		$iPageMax_output = intval($this->_maxPage)+1;
		$aTplDefault = array(
			"outer"   => "%s",
			"outerWhenNull" => "",
			"href"    => "?page=%d",
			"link"    => "<li><a href=\"%s\">%s</a></li>",
			"current" => "<li><span class=\"current\">%s</span></li>",
			"prePage" => "<ul><li><a href=\"%s\">上一页</a></li>",
			"nextPage" => "<li><a href=\"%s\">下一页</a></li></ul>",
			"dot"     => "<li>...</li>",
			"number"  => "%2d",
			"total"  => "<span class=\"flip_total\">共 $iPageMax_output 页 $this->_totalNumber 条</span>",
		);
		
		$aTpl += $aTplDefault;

        // 补全url
        if (substr($aTpl["href"], 0, 1) == '?') {
            $aTpl["href"] = 'http://...' . $aTpl["href"];
        }

		if (!empty($aTpl["outerWhenNull"]) && empty($this->_maxPage)) {
			return "";
		}

		if (empty($this->_aPageSlice)) {
			$this->slice();
		}
		$aSlice = $this->_aPageSlice;

		$sHTML = "";
		$iPrevNumber = current($aSlice);
		foreach ($aSlice as $iNumber) {
			if (1 < $iNumber - $iPrevNumber) {
				$sHTML .= $aTpl["dot"];
			}
			$sNumber = sprintf($aTpl["number"], $iNumber + 1);
			if ($iNumber == $this->_currentPage) {
				$sHTML .= sprintf($aTpl["current"], $sNumber);
			} else {
				$sHref = sprintf($aTpl["href"], $iNumber);
				$sHTML .= sprintf($aTpl["link"], self::encodeURI($sHref), $sNumber);
			}
			$iPrevNumber = $iNumber;
		}

		//上一页
		$sHref = sprintf($aTpl["href"], ($this->_currentPage-1)>0?($this->_currentPage-1):0);
		if($this->_currentPage == 0) {
			$sHTML = "<ul><li><a href=\"javascript:void(0);\">上一页</a></li>" . $sHTML;
		} else {
			$sHTML = sprintf($aTpl["prePage"], self::encodeURI($sHref)) . $sHTML;
		}
		
		//下一页
		$sHref = sprintf($aTpl["href"], ($this->_currentPage+1)<$this->_maxPage?$this->_currentPage+1:$this->_maxPage);
		if($this->_currentPage == $this->_maxPage) {
			$sHTML .= "<li><a href=\"javascript:void(0);\">下一页</a></li></ul>";
		} else {
			$sHTML .= sprintf($aTpl["nextPage"], self::encodeURI($sHref));
		}
		
		//汇总信息
		$sHTML = $sHTML. $aTpl["total"];
		$sHTML = sprintf($aTpl[empty($this->_iPageMax) ? "outerWhenNull" : "outer"], $sHTML);
		
		return ($sHTML);
    }
    
    public function getNumber() {
		return array(
			"count" => $this->_totalNumber,
			"pageNow" => $this->_currentPage,
			"pageMax" => $this->_maxPage,
			"numberPerPage" => $this->_perPage,
		);
	}
}