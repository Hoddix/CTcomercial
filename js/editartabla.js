function init()
{
	var tables = document.getElementsByClassName("editabletable");
	var i;
	for (i = 0; i < tables.length; i++)
	{
		makeTableEditable(tables[i]);
	}
}

function makeTableEditable(table)
{
	var rows = table.rows;
	var r;
	for (r = 0; r < rows.length; r++)
	{
		var cols = rows[r].cells;
		var c;
		for (c = 0; c < cols.length; c++)
		{
			var cell = cols[c];
			var listener = makeEditListener(table, r, c);
			cell.addEventListener("input", listener, false);
		}
	}
}

function makeEditListener(table, row, col)
{
	return function(event)
	{
		var cell = getCellElement(table, row, col);
		var text = cell.innerHTML.replace(/<br>$/, '');
		//var items = split(text);

		if (items.length === 1)
		{
			// Text is a single element, so do nothing.
			// Without this each keypress resets the focus.
			return;
		}

		var i;
		var r = row;
		var c = col;
		for (i = 0; i < items.length && r < table.rows.length; i++)
		{
			cell = getCellElement(table, r, c);
			cell.innerHTML = items[i]; // doesn't escape HTML

			c++;
			if (c === table.rows[r].cells.length)
			{
				r++;
				c = 0;
			}
		}
		cell.focus();
	};
}

function getCellElement(table, row, col)
{
	// assume each cell contains a div with the text
	return table.rows[row].cells[col].firstChild;

}

function split(str)
{
	// use comma and whitespace as delimiters
	return str.split(/,|\s|<br>/);
}

init();




$('.table').on('blur','.cantidad',function(){

	var stock = $('#productoSelecionado').data('stock');
	var nuevaCantidad = $(this).text();
	var precioUnitario = $(this).parent().find('.precioUnitario').data('val');
	
	if(!isNaN(nuevaCantidad) && nuevaCantidad > 0){
		if(stock < nuevaCantidad){

			alert("Stock sobrepasado. Disponibles: "+stock)

			$('#cantidadU').val("0");

			$('#cantidadC').val("0");

			

		}else{

			$(this).data('val',nuevaCantidad);

			nuevaCantidad = $(this).data('val');

			var totalUnitario = nuevaCantidad*precioUnitario;

			$(this).parent().find('.totalUnitario').data('val',totalUnitario);
			$(this).parent().find('.totalUnitario').html(totalUnitario);

			comun.calcularTotal();
		}
	}else{
		$(this).text($(this).data('val'));
	}


});

