<?php
/* first published by  http://www.sitepoint.com/article/php-paging-result-sets/6
   Adapted for mysqli 
   Adapted for __construct instead of classname constructor function
 * 
*/

class MySQLPagedResultSet
{

  var $results;
  var $pageSize;
  var $page;
  var $row;
  
  function __construct($query,$pageSize,$cnx)
  {
    if (isset($_GET['resultpage'])) {
      $resultpage = $_GET['resultpage'];
    } else {
      // for a change not start counting at 0
      $resultpage = 1;
    }
    
    $this->results = @mysqli_query($cnx,$query);
    $this->pageSize = $pageSize;
    if ((int)$resultpage <= 0) $resultpage = 1;
    if ($resultpage > $this->getNumPages())
      $resultpage = $this->getNumPages();
    $this->setPageNum($resultpage);
  }
  
  function getNumPages()
  {
    if (!$this->results) return FALSE;
    
    return ceil(mysqli_num_rows($this->results) /
                (float)$this->pageSize);
  }
  
  function setPageNum($pageNum)
  {
    if ($pageNum > $this->getNumPages() or
        $pageNum <= 0) return FALSE;
  
    $this->page = $pageNum;
    $this->row = 0;
    mysqli_data_seek($this->results,($pageNum-1) * $this->pageSize);
  }
  
  function getPageNum()
  {
    return $this->page;
  }
  
  function isLastPage()
  {
    return ($this->page >= $this->getNumPages());
  }
  
  function isFirstPage()
  {
    return ($this->page <= 1);
  }
  
  function fetchArray()
  {
    if (!$this->results) return FALSE;
    if ($this->row >= $this->pageSize) return FALSE;
    $this->row++;
    return mysqli_fetch_array($this->results);
  }

  function fetchObject() 
  {
    if (!$this->results) return FALSE;
    if ($this->row >= $this->pageSize) return FALSE;
    $this->row++;
    return mysqli_fetch_object($this->results);
  }

  
  function getPageNav($queryvars = '')
  {
    $nav = '';
    if (!$this->isFirstPage())
    {
      $nav .= "<a href=\"?resultpage=".
              ($this->getPageNum()-1).'&'.$queryvars.'">&lt;&lt; ' . T_("Previous") . '</a> ';
    }
    if ($this->getNumPages() > 1)
      for ($i=1; $i<=$this->getNumPages(); $i++)
      {
        if ($i==$this->page)
          $nav .= "$i |  ";
        else
          $nav .= "  <a href=\"?resultpage={$i}&".
                  $queryvars."\">{$i}</a> | ";
      }
    if (!$this->isLastPage())
    {
      $nav .= "<a href=\"?resultpage=".
              ($this->getPageNum()+1).'&'.$queryvars.'">' . T_("Next") . ' &gt;&gt;</a>';
    }
    
    return $nav;
  }
}

?>
