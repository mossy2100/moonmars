<script id="shader-fs" type="x-shader/x-fragment">
  varying lowp vec4 vColor;
  
  void main(void) {
    gl_FragColor = vColor;
  }
</script>

<script id="shader-vs" type="x-shader/x-vertex">
  attribute vec3 aVertexPosition;
  attribute vec4 aVertexColor;
 
  uniform mat4 uMVMatrix;
  uniform mat4 uPMatrix;
   
  varying lowp vec4 vColor;
  
  void main(void) {
    gl_Position = uPMatrix * uMVMatrix * vec4(aVertexPosition, 1.0);
    vColor = aVertexColor;
  }
</script>

<canvas id="glcanvas">
  Your browser doesn't appear to support the HTML5 <code>&lt;canvas&gt;</code> element.
</canvas>
