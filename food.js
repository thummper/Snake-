function Food() {
    this.x; 
    this.y; 
    
    this.pickLocation = function() {
        this.x = Math.round(Math.random() * 48) * 14;
        this.y = Math.round(Math.random() * 41) * 14;
    }
    this.show = function() {
        
    }
    
    
}