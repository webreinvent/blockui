export default {
  name: 'Create',
  components: {

  },
  data()
  {
    let obj = {
      render_html: "",
      iframe: null,
      code_mirror: `<html><body><h1>Testing</h1></body></html>`,
      cmOption: {
        tabSize: 4,
        styleActiveLine: true,
        lineNumbers: true,
        line: true,
        foldGutter: true,
        styleSelectedText: true,
        mode: 'text/html',
        keyMap: "sublime",
        matchBrackets: true,
        showCursorWhenSelecting: true,
        theme: "monokai",
        extraKeys: { "Ctrl": "autocomplete" },
        hintOptions:{
          completeSingle: false
        }
      },

    };
    return obj;
  },
  mounted()
  {
    //this.getData();
  },
  methods: {
    onCmCodeChange: function (data) {

      var iframe = document.getElementById('frame');

      iframe.contentWindow.document.open();
      iframe.contentWindow.document.write(data);
      iframe.contentWindow.document.close();



    },
    getData: function () {
      this.iframe = this.$refs.ifrm;
      console.log('test-->', this.iframe);
    }
  }
}
