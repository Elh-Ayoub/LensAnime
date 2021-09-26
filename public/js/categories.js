    class Circular{
        arr = [];
        constructor(arr) {
            this.arr = arr;
        }
        get(index) {
            let i = index;
            while(i >= this.arr.length){
                i -= this.arr.length;
            }
            return this.arr[i];
        }
        size(){
            return this.arr.length;
        }
    }
    classes = ['bg-gradient-red', 'bg-gradient-blue', 'bg-gradient-info', 'bg-gradient-gray-dark', 'bg-gradient-light', 'bg-gradient-purple', 'bg-gradient-green', 'bg-gradient-warning'];
    const bg = new Circular(classes);
    let categories = $('.categories');
    $('.categories').each(function(i, obj) {
        $('#' + obj.id).addClass(bg.get(i));        
    });
