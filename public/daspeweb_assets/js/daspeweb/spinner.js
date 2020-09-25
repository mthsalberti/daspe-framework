class SpinnerController{
    constructor(){
        this.enable();
    }
    getEle(){return $('#loader-spinner-main');}
    disable(){this.getEle().addClass('d-none');}
    getContentHTML(){return `<div id="loader-spinner-main" 
   class="position-absolute d-none fixed-top w-100 h-100"
   style="z-index: 9999; background-color: #8a8a8aa8;">    
   <div class="preloader-wrapper big active position-absolute " style="left: 50%; top: 40%" >     
      <div class="spinner-layer spinner-red-only">        
          <div class="circle-clipper left"><div class="circle"></div></div>          
            <div class="gap-patch"><div class="circle"></div></div>            
            <div class="circle-clipper right"><div class="circle"></div></div>        
            </div>    </div></div>`;}
    enable(){
        if(this.getEle().length == 0)
            $(this.getContentHTML()).hide().appendTo("body").fadeIn(1000);
        this.getEle().removeClass('d-none');
    }

}
