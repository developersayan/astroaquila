<?php
    use App\Models\CurrencyConversion;
    function currencyConversionCustom()
    {
    	$conversion = CurrencyConversion::where('to_currency',@session()->get('currency'))->first();
    	return $conversion->conversion_factor;
    }
	function getDateTimeDiff($date1,$date2)
	{
		$dateTimeObject1 = date_create($date1); 
		$dateTimeObject2 = date_create($date2);
		$interval = date_diff($dateTimeObject1, $dateTimeObject2);
		$html = '';
		if($interval->y>0)
		{
			if($interval->y==1)
			{
				$html=$interval->y.' year ago';
			}
			else
			{
				$html=$interval->y.' years ago';
			}
		}
		else
		{
			if($interval->m>0)
			{
				if($interval->m==1)
				{
					$html=$interval->m.' month ago';
				}
				else
				{
					$html=$interval->m.' months ago';
				}
			}
			else
			{
				if($interval->d>0)
				{
					if($interval->d==1)
					{
						$html=$interval->d.' day ago';
					}
					else
					{
						$html=$interval->d.' days ago';
					}
				}
				else
				{
					if($interval->h>0)
					{
						if($interval->h==1)
						{
							$html=$interval->h.' hour ago';
						}
						else
						{
							$html=$interval->h.' hours ago';
						}
					}
					else
					{
						if($interval->i>0)
						{
							if($interval->i==1)
							{
								$html=$interval->i.' minute ago';
							}
							else
							{
								$html=$interval->i.' minutes ago';
							}
						}
						else
						{
							if($interval->s<2)
							{
								$html=$interval->s.' second ago';
							}
							else
							{
								$html=$interval->s.' seconds ago';
							}
						}
					}
				}
			}
		}
		return $html;
	}


?>
