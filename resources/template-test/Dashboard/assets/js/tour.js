 function enableDragSort(listClass) {
    const sortableLists = document.getElementsByClassName(listClass);
    Array.prototype.map.call(sortableLists, (list) => {enableDragList(list)});
  }
  
  function enableDragList(list) {
    Array.prototype.map.call(list.children, (item) => {enableDragItem(item)});
  }
  
  function enableDragItem(item) {
    item.setAttribute('draggable', true)
    item.ondrag = handleDrag;
    item.ondragend = handleDrop;
  }
  
  function handleDrag(item) {
    const selectedItem = item.target,
          list = selectedItem.parentNode,
          x = event.clientX,
          y = event.clientY;
    
    selectedItem.classList.add('drag-sort-active');
    let swapItem = document.elementFromPoint(x, y) === null ? selectedItem : document.elementFromPoint(x, y);
    
    if (list === swapItem.parentNode) {
      swapItem = swapItem !== selectedItem.nextSibling ? swapItem : swapItem.nextSibling;
      list.insertBefore(selectedItem, swapItem);
    }
  }
  
  function handleDrop(item) {
    item.target.classList.remove('drag-sort-active');
  }
  
  (()=> {enableDragSort('drag-sort-enable')})();

  //height element
  var el1 = document.querySelector('.tour-show .side-right'),
      el2 = document.querySelector('.tour-show .secondary-sidebar');

  if (el1.offsetHeight > el2.offsetHeight){
      el2.style.height = el1.offsetHeight + 'px';
  }else if (el1.offsetHeight < el2.offsetHeight){
      el1.style.height = el2.offsetHeight + 'px';
  }

// show ducument