const _ = require('underscore');

_.mixin({
  copy(obj){
    return JSON.parse(JSON.stringify(obj));
  },

  randomId(prefix){
  	prefix = prefix || "";
  	return _.uniqueId(prefix + Math.ceil(Math.random() * 1000000));
  },

  move(array, fromIndex, toIndex) {
    let arr = _.copy(array);
    arr.splice(toIndex, 0, arr.splice(fromIndex, 1)[0] );
    return arr;
  },

  getPosition(element) {
    var xPosition = 0;
    var yPosition = 0;
  
    while(element) {
        xPosition += (element.offsetLeft - element.scrollLeft + element.clientLeft);
        yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
        element = element.offsetParent;
    }
    return { x: xPosition, y: yPosition };
  }
});