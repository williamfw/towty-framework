/**
 * @author Will
 * Esse arquivo possui alguns métodos JS útils para a aplicação.
 * Ele deve ser o último arquivo chamado no header da MasterPage, pois nele é utilizado alguns plugins jquery.
 */

//usado no DataGrid do JEasyUi. O método é usado para formatar colunas com informações do tipo data.
function ConverteDataDeGrid(dataString)
{
	var dataHora = dataString.split(' ');
	var data = new Date(dataHora[0]);
	
	var dia;
	var mes;
	
	if(data.getDate() < 9)
		dia = '0' + (data.getDate() + 1);
	 else
	 	dia = data.getDate() + 1;
	
	if(data.getMonth() < 9)
		mes = '0' + (data.getMonth() + 1);
	 else
	 	mes = data.getMonth() + 1;
	
	return dia + '/' + mes + '/' + data.getFullYear() + ' ' + dataHora[1];    
}


$(document).ready(function() {
	// Formatação padrão para DateBox e DateTimeBox no padrão nacional! (ex: 08/05/2013) 
	$.fn.datebox.defaults.formatter = function(date)
	{
		var dia = date.getDate();
		var mes = date.getMonth() + 1;
	 	var ano = date.getFullYear();		
		
		return (dia < 10 ? ('0' + dia) : dia) + '/' + (mes < 10 ? ('0' + mes) : mes) + '/' + ano;
	}
	
	//Converte uma data no padrão nacional para um objeto Date!
	$.fn.datebox.defaults.parser = function(date)
	{
		if(!date) 
			return new Date();
		
		var split = date.split('/');
		var dia = parseInt(split[0],10);
		var mes = parseInt(split[1],10);		
		var ano = parseInt(split[2],10);
		
		if (!isNaN(ano) && !isNaN(mes) && !isNaN(dia))
			return new Date(ano, mes - 1, dia);
		else
			return new Date();
	};
	
	//transforma num campo tipo data com calendário	
	if($('.date_time').length > 0)
	{
		$('.date_time').datetimebox().datetimebox('textbox').mask("99/99/9999 99:99:99", {placeholder:" "});
	} 	
});
