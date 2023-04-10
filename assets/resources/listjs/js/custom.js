var list_page=10;
var monkeyList = new List('users', {
  valueNames: ['name', 'born' ],
  page: list_page,
  pagination: true
});
console.log(Math.ceil(monkeyList.size()/list_page));
var i = 1;

       

// $('#users').find('ul.pagination').prepend('<li class="endlist"><a class="page" href="">First</a></li>');
$('.firstlist').on('click', function (e) {
	 i=1;
            monkeyList.show(1, list_page);
            $(".value .text").html(i);
           
            return false;

        });

	$('.next').on('click', function () {
		
		if (i<Math.ceil(monkeyList.size()/list_page)) {
			
            console.log("next");
            
            monkeyList.show((i*list_page)+1, list_page);
            i++;
            $(".value .text").html(i);
            console.log(i);
            
            }
            return false;
        });


	$('.prev').on('click', function () {
		i--;
		if (i>1) {
			
            console.log("prev");
            
            monkeyList.show(((i-1)*list_page+1), list_page);
            console.log(i);

            $(".value .text").html(i);
            
            }else{
            	if(i==1){
	            // i--;
	            monkeyList.show(0, list_page);
	            $(".value .text").html(i);
	            console.log(i);
	            

	            }
            }
            
             return false;
            
        });	


 		

        

// $('#users').find('ul.pagination').append('<li class="endlist"><a class="page" href="">End</a></li>');
$('.endlist').on('click', function (e) {
    console.log(i);
	i=Math.ceil(monkeyList.size()/list_page);
	console.log(i);
            monkeyList.show(monkeyList.size()-list_page, list_page+1);
            $(".value .text").html(i);
            // i=Math.round(monkeyList.size()/list_page)+1;
            
            return false;
        });