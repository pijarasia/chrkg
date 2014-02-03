<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2012, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

//--------------------------------------------------------------------

/**
 * Form Helpers
 *
 * Creates HTML5 extensions for the standard CodeIgniter form helper.
 *
 * These functions also wrap the form elements as necessary to create
 * the styling that the Bootstrap-inspired admin theme requires to
 * make it as simple as possible for a developer to maintain styling
 * with the core. Also makes changing the core a snap.
 *
 * All methods (including overridden versions of the originals) now
 * support passing a final 'label' attribute that will create the
 * label along with the field.
 *
 * @package    Bonfire
 * @subpackage Helpers
 * @category   Helpers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/array_helpers.html
 *
 */

if ( ! function_exists('_form_common'))
{
	/**
	 * Used by many of the new functions to wrap the input in the correct
	 * tags so that the styling is automatic.
	 *
	 * @access private
	 *
	 * @param string $type    A string with the name of the element type.
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function _form_common($type='text', $data='', $value='', $label='', $extra='', $tooltip = '')
	{
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'value' => $value,'label' => $label);

		// If name is empty at this point, try to grab it from the $data array
		if (empty($defaults['name']) && is_array($data) && isset($data['name']))
		{
			$defaults['name'] = $data['name'];
			unset($data['name']);
		}
		if (empty($defaults['value']) && is_array($data) && isset($data['value']))
		{
			$defaults['value'] = $data['value'];
			unset($data['value']);
		}
		if (empty($defaults['label']) && is_array($data) && isset($data['label']))
		{
			$defaults['label'] = $data['label'];
			unset($data['label']);
		}

		if (is_array($data) && isset($data['append']))
		{
			$append = "<span class='add-on'>{$data['append']}</span>";
			unset($data['append']);
		}

		if (is_array($data) && isset($data['prepend']))
		{
			$prepend = "<span class='add-on'>{$data['prepend']}</span>";
			unset($data['prepend']);
		}
		$error = '';

		if (function_exists('form_error'))
		{
			if (form_error($defaults['name']))
			{
				$error   = ' error';
				$tooltip = '<span class="help-inline">' . form_error($defaults['name']) . '</span>' . PHP_EOL;
			}
		}

		$output = _parse_form_attributes($data, $defaults);

		$output = <<<EOL

<div class="control-group {$error}">
	<label class="control-label" for="{$defaults['name']}">{$defaults['label']}</label>
	<div class="controls">
		 <div class="input-prepend input-append">
		  {$append}
		  <input {$output} {$defaults['extra']} placeholder="{$defaults['label']}" value="{$defaults['value']}" />
		  {$prepend}
		  {$tooltip}
		</div>
	</div>
</div>

EOL;

		return $output;

	}//end _form_common()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_input'))
{
	/**
	 * Returns a properly templated text input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_input($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('text', $data, $value, $label, $extra, $tooltip);

	}//end form_input()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_email'))
{
	/**
	 * Returns a properly templated email input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_email($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('email', $data, $value, $label, $extra, $tooltip);

	}//end form_email()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_password'))
{
	/**
	 * Returns a properly templated password input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_password($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('password', $data, $value, $label, $extra, $tooltip);

	}//end form_password()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_url'))
{
	/**
	 * Returns a properly templated URL input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_url($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('url', $data, $value, $label, $extra, $tooltip);

	}//end form_url()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_telephone'))
{
	/**
	 * Returns a properly templated Telephone input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_telephone($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('tel', $data, $value, $label, $extra, $tooltip);

	}//end form_telephone()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_number'))
{
	/**
	 * Returns a properly templated number input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_number($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('number', $data, $value, $label, $extra, $tooltip);

	}//end form_number()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_color'))
{
	/**
	 * Returns a properly templated color input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_color($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('color', $data, $value, $label, $extra, $tooltip);

	}//end form_color()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_search'))
{
	/**
	 * Returns a properly templated search input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_search($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('search', $data, $value, $label, $extra, $tooltip);

	}//end form_search()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_date'))
{
	/**
	 * Returns a properly templated date input field.
	 *
	 * @param string $data    Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param string $value   Either a string with the value, or blank if an array is passed to the $data param.
	 * @param string $label   A string with the label of the element.
	 * @param string $extra   A string with any additional items to include, like Javascript.
	 * @param string $tooltip A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_date($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		return _form_common('date', $data, $value, $label, $extra, $tooltip);

	}//end form_date()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_dropdown'))
{
	/**
	 * Returns a properly templated date dropdown field.
	 *
	 * @param string $data     Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param array  $options  Array of options for the drop down list
	 * @param string $selected Either a string of the selected item or an array of selected items
	 * @param string $label    A string with the label of the element.
	 * @param string $extra    A string with any additional items to include, like Javascript.
	 * @param string $tooltip  A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_dropdown($data, $options=array(), $selected='', $label='', $extra='', $tooltip = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'label' => $label, 'selected' => $selected);

		// If name is empty at this point, try to grab it from the $data array
		if (empty($defaults['name']) && is_array($data) && isset($data['name']))
		{
			$defaults['name'] = $data['name'];
			unset($data['name']);
		}

		if (empty($defaults['label']) && is_array($data) && isset($data['label']))
		{
			$defaults['label'] = $data['label'];
			unset($data['label']);
		}

		if (empty($defaults['selected']) && is_array($data) && isset($data['selected']))
		{
			$selected = $data['selected'];
			unset($data['selected']);
		}

		$output = _parse_form_attributes($data, $defaults);

		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$data['name']]))
			{
				$selected = array($_POST[$data['name']]);
			}
		}

		$options_vals = '';
		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$options_vals .= '<optgroup label="'.$key.'">'.PHP_EOL;

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$options_vals .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$options_vals .= '</optgroup>'.PHP_EOL;
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$options_vals .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$error = '';

		if (function_exists('form_error'))
		{
			if (form_error($defaults['name']))
			{
				$error   = ' error';
				$tooltip = '<span class="help-inline">' . form_error($defaults['name']) . '</span>' . PHP_EOL;
			}
		}

		$output = <<<EOL

<div class="control-group {$error}">
	<label class="control-label" for="{$defaults['name']}">{$defaults['label']}</label>
	<div class="controls">
		 <select {$output} {$defaults['extra']} data-container="body">
			{$options_vals}
		</select>
		{$tooltip}
	</div>
</div>

EOL;

		return $output;

	}//end form_dropdown()
}


//--------------------------------------------------------------------

if ( ! function_exists('form_dropdown_assisted'))
{
	/**
	 * Returns a properly templated date dropdown field.
	 *
	 * @param string $data     Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param array  $options  Array of options for the drop down list
	 * @param string $selected Either a string of the selected item or an array of selected items
	 * @param string $label    A string with the label of the element.
	 * @param string $extra    A string with any additional items to include, like Javascript.
	 * @param string $tooltip  A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_dropdown_assisted($data, $options=array(), $assisted = '',$selected='', $label='', $extra='', $tooltip = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'label' => $label, 'selected' => $selected, 'assisted' => $assisted);

		// If name is empty at this point, try to grab it from the $data array
		if (empty($defaults['name']) && is_array($data) && isset($data['name']))
		{
			$defaults['name'] = $data['name'];
			unset($data['name']);
		}

		if (empty($defaults['label']) && is_array($data) && isset($data['label']))
		{
			$defaults['label'] = $data['label'];
			unset($data['label']);
		}

		if (empty($defaults['selected']) && is_array($data) && isset($data['selected']))
		{
			$selected = $data['selected'];
			unset($data['selected']);
		}

		if (!empty($defaults['assisted']))
		{
			$assisted = array($defaults['assisted']);
		}

		$output = _parse_form_attributes($data, $defaults);

		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$data['name']]))
			{
				$selected = array($_POST[$data['name']]);
			}
		}

		$options_vals = '';
		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$options_vals .= '<optgroup label="'.$key.'">'.PHP_EOL;

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$options_vals .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$options_vals .= '</optgroup>'.PHP_EOL;
			}
			else
			{
				$sel = (in_array($key, $assisted)) ? ' selected="selected"' : '';

				$options_vals .= (in_array($key, $assisted)) ? '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n": '';
			}
		}

		$error = '';

		if (function_exists('form_error'))
		{
			if (form_error($defaults['name']))
			{
				$error   = ' error';
				$tooltip = '<span class="help-inline">' . form_error($defaults['name']) . '</span>' . PHP_EOL;
			}
		}

		$output = <<<EOL

<div class="control-group {$error}">
	<label class="control-label" for="{$defaults['name']}">{$defaults['label']}</label>
	<div class="controls">
		 <select {$output} {$defaults['extra']} data-container="body">
			{$options_vals}
		</select>
		{$tooltip}
	</div>
</div>

EOL;

		return $output;

	}//end form_dropdown()
}

//--------------------------------------------------------------------

if ( ! function_exists('form_dropdown_multiple'))
{
	/**
	 * Returns a properly templated date dropdown field.
	 *
	 * @param string $data     Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param array  $options  Array of options for the drop down list
	 * @param string $selected Either a string of the selected item or an array of selected items
	 * @param string $label    A string with the label of the element.
	 * @param string $extra    A string with any additional items to include, like Javascript.
	 * @param string $tooltip  A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_dropdown_multiple($data, $options=array(), $selected='', $label='', $extra='', $tooltip = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'label' => $label, 'selected' => $selected);

		// If name is empty at this point, try to grab it from the $data array
		if (empty($defaults['name']) && is_array($data) && isset($data['name']))
		{
			$defaults['name'] = $data['name'];
			unset($data['name']);
		}

		if (empty($defaults['label']) && is_array($data) && isset($data['label']))
		{
			$defaults['label'] = $data['label'];
			unset($data['label']);
		}

		if (empty($defaults['selected']) && is_array($data) && isset($data['selected']))
		{
			$selected = $data['selected'];
			unset($defaults['selected']);
			unset($data['selected']);
		}

		$output = _parse_form_attributes($data, $defaults);

		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$data['name']]))
			{
				$selected = array($_POST[$data['name']]);
			}
		}

		$options_vals = '';
		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$options_vals .= '<optgroup label="'.$key.'">'.PHP_EOL;

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$options_vals .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$options_vals .= '</optgroup>'.PHP_EOL;
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$options_vals .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$error = '';

		if (function_exists('form_error'))
		{
			if (form_error($defaults['name']))
			{
				$error   = ' error';
				$tooltip = '<span class="help-inline">' . form_error($defaults['name']) . '</span>' . PHP_EOL;
			}
		}

		$output = <<<EOL

<div class="control-group {$error}">
	<label class="control-label" for="{$defaults['name']}">{$defaults['label']}</label>
	<div class="controls">
		 <select {$output} {$defaults['extra']} multiple data-width="40%" data-selected-text-format="count>3" title='Please select ....' data-container="body">
			{$options_vals}
		</select>
		{$tooltip}
	</div>
</div>

EOL;

		return $output;

	}//end form_dropdown_multiple()
}
/**
 * Textarea field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_textarea'))
{
	function form_textarea($data='', $value='', $label='', $extra='', $tooltip = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'cols' => '40', 'rows' => '10', 'label' => $label);

		if (empty($defaults['name']) && is_array($data) && isset($data['name']))
		{
			$defaults['name'] = $data['name'];
			unset($data['name']);
		}
		{
			$defaults['value'] = $data['value'];
			unset($data['value']);
		}
		if (empty($defaults['label']) && is_array($data) && isset($data['label']))
		{
			$defaults['label'] = $data['label'];
			unset($data['label']);
		}
		if (empty($defaults['extra']) && is_array($data) && isset($data['extra']))
		{
			$defaults['extra'] = $data['extra'];
			unset($data['extra']);
		}

		$output = _parse_form_attributes($data, $defaults);
		$val = form_prep($defaults['value'], $defaults['name']);
		$output = <<<EOL

<div class="control-group {$error}">
	<label class="control-label" for="{$defaults['name']}">{$defaults['label']}</label>
	<div class="controls">
		 <textarea {$output} {$defaults['extra']} placeholder="{$defaults['label']}">{$val}</textarea>
		{$tooltip}
	</div>
</div>

EOL;
		return $output;
	}
}

if ( ! function_exists('form_wysiwyg'))
{
	function form_wysiwyg($name){
$output = <<<EOL
<div class="btn-toolbar" data-role="editor-toolbar" data-target="#$name">
  <div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font"><i class="icon-font"></i><b class="caret"></b></a>
      <ul class="dropdown-menu">
      <li><a data-edit="fontName Serif" style="font-family:'Serif'">Serif</a></li><li><a data-edit="fontName Sans" style="font-family:'Sans'">Sans</a></li><li><a data-edit="fontName Arial" style="font-family:'Arial'">Arial</a></li><li><a data-edit="fontName Arial Black" style="font-family:'Arial Black'">Arial Black</a></li><li><a data-edit="fontName Courier" style="font-family:'Courier'">Courier</a></li><li><a data-edit="fontName Courier New" style="font-family:'Courier New'">Courier New</a></li><li><a data-edit="fontName Comic Sans MS" style="font-family:'Comic Sans MS'">Comic Sans MS</a></li><li><a data-edit="fontName Helvetica" style="font-family:'Helvetica'">Helvetica</a></li><li><a data-edit="fontName Impact" style="font-family:'Impact'">Impact</a></li><li><a data-edit="fontName Lucida Grande" style="font-family:'Lucida Grande'">Lucida Grande</a></li><li><a data-edit="fontName Lucida Sans" style="font-family:'Lucida Sans'">Lucida Sans</a></li><li><a data-edit="fontName Tahoma" style="font-family:'Tahoma'">Tahoma</a></li><li><a data-edit="fontName Times" style="font-family:'Times'">Times</a></li><li><a data-edit="fontName Times New Roman" style="font-family:'Times New Roman'">Times New Roman</a></li><li><a data-edit="fontName Verdana" style="font-family:'Verdana'">Verdana</a></li></ul>
    </div>
  <div class="btn-group">
    <a class="btn dropdown-toggle" data-toggle="dropdown" title="" data-original-title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
      <ul class="dropdown-menu">
      <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
      <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
      <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
      </ul>
  </div>
  <div class="btn-group">
    <a class="btn" data-edit="bold" title="" data-original-title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
    <a class="btn" data-edit="italic" title="" data-original-title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
    <a class="btn" data-edit="strikethrough" title="" data-original-title="Strikethrough"><i class="icon-strikethrough"></i></a>
    <a class="btn" data-edit="underline" title="" data-original-title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
  </div>
  <div class="btn-group">
    <a class="btn" data-edit="insertunorderedlist" title="" data-original-title="Bullet list"><i class="icon-list-ul"></i></a>
    <a class="btn" data-edit="insertorderedlist" title="" data-original-title="Number list"><i class="icon-list-ol"></i></a>
    <a class="btn" data-edit="outdent" title="" data-original-title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
    <a class="btn" data-edit="indent" title="" data-original-title="Indent (Tab)"><i class="icon-indent-right"></i></a>
  </div>
  <div class="btn-group">
    <a class="btn btn-info" data-edit="justifyleft" title="" data-original-title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
    <a class="btn" data-edit="justifycenter" title="" data-original-title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
    <a class="btn" data-edit="justifyright" title="" data-original-title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
    <a class="btn" data-edit="justifyfull" title="" data-original-title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
  </div>
</div>
EOL;
	return $output;
	}
}


//--------------------------------------------------------------------

if ( ! function_exists('form_dropdown_blank'))
{
	/**
	 * Returns a properly templated date dropdown field.
	 *
	 * @param string $data     Either a string with the element name, or an array of key/value pairs of all attributes.
	 * @param array  $options  Array of options for the drop down list
	 * @param string $selected Either a string of the selected item or an array of selected items
	 * @param string $label    A string with the label of the element.
	 * @param string $extra    A string with any additional items to include, like Javascript.
	 * @param string $tooltip  A string for inline help or a tooltip icon
	 *
	 * @return string A string with the formatted input element, label tag and wrapping divs.
	 */
	function form_dropdown_blank($data, $options=array(), $selected='', $label='', $extra='', $tooltip = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'label' => $label, 'selected' => $selected);

		// If name is empty at this point, try to grab it from the $data array
		if (empty($defaults['name']) && is_array($data) && isset($data['name']))
		{
			$defaults['name'] = $data['name'];
			unset($data['name']);
		}

		if (empty($defaults['label']) && is_array($data) && isset($data['label']))
		{
			$defaults['label'] = $data['label'];
			unset($data['label']);
		}

		if (empty($defaults['selected']) && is_array($data) && isset($data['selected']))
		{
			$selected = $data['selected'];
			unset($data['selected']);
		}

		$output = _parse_form_attributes($data, $defaults);

		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$data['name']]))
			{
				$selected = array($_POST[$data['name']]);
			}
		}

		$options_vals = '';
		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$options_vals .= '<optgroup label="'.$key.'">'.PHP_EOL;

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$options_vals .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$options_vals .= '</optgroup>'.PHP_EOL;
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$options_vals .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$error = '';

		if (function_exists('form_error'))
		{
			if (form_error($defaults['name']))
			{
				$error   = ' error';
				$tooltip = '<span class="help-inline">' . form_error($defaults['name']) . '</span>' . PHP_EOL;
			}
		}

		$output = <<<EOL

		<select {$output} {$defaults['extra']} data-container="body">
			{$options_vals}
		</select>

EOL;

		return $output;

	}//end form_dropdown()
}