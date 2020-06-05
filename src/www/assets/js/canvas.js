/**
*     Author              :  Dominique Aigroz.
*     Project             :  ProjetTPI.
*     Page                :  canvas.js
*     Brief               :  Functions used for canvas.
*     Date                :  05.06.2020.
*/

/** 
 * @brief Render html compenent to a svg drawn in a canvas
 * 
 * @param {*} html compenent html to render
 * @param {*} ctx canvas context
 * @param {*} x image position x 
 * @param {*} y image position y
 * @param {*} width image width 
 * @param {*} height image height
 * 
 * @return void
 */
function render_html_to_canvas(html, ctx, x, y, width, height) {
    var data = "data:image/svg+xml;charset=utf-8," + '<svg xmlns="http://www.w3.org/2000/svg" width="' + width + '" height="' + height + '">' +
      '<foreignObject x="' + y + '" y="' + y + '" width="' + width + '" height="' + height + '">' +
      html_to_xml(html) +
      '</foreignObject>' +
      '</svg>';
  
    var img = new Image();
    img.onload = function() {
      ctx.drawImage(img, x, y);
    }
    img.src = data;
  }
  /**
   * @brief Convert html compenent to xml
   * 
   * @param {*} html html compenent
   * 
   * @return string the html compenent converted in xml string
   */
  function html_to_xml(html) {
    var doc = document.implementation.createHTMLDocument('');
    doc.write(html);
  
    // You must manually set the xmlns if you intend to immediately serialize     
    // the HTML document to a string as opposed to appending it to a
    // <foreignObject> in the DOM
    doc.documentElement.setAttribute('xmlns', doc.documentElement.namespaceURI);
  
    // Get well-formed markup
    html = (new XMLSerializer).serializeToString(doc.body);
    return html;
  }
  
  