export const iframeCode = `
<style>
    body {height: 9%; background: #FFFFFF;}
    .content {width: 100%;}
</style>
  <div class="content"></div>
  <script type="text/javascript">
    if (dataFromParent) {
      // Subscribe to the Subject so you can trigger changes from Angular
      dataFromParent.subscribe(res => {
        document.querySelector('.content').innerHTML = res;
      })
    }
  </script>
`