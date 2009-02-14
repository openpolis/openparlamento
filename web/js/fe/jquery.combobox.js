/*
jquery.combobox
version 0.1.2.7

Copyright © 2007,2008 Minel Pather|Ahura Mazda|jquery.sanchezsalvador.com
Dual licensed under MIT and GPL licences:
	* www.opensource.org/licenses/mit-license.php
	* www.gnu.org/licenses/gpl.html
*/
jQuery.fn.combobox =
	function(styles, options, callback)
	{
		var _context = this;
		// create a combobox class instance instead of jQuery.fn.combobox which is a namespace.
		this.combobox = new Function();
		
		// Style Settings that determine the look of the control
		var styleSettings =
		{		
			comboboxContainerClass: null,
			comboboxValueContentContainerClass: null,
			comboboxValueContentClass: null,
			comboboxDropDownButtonClass: null,
			comboboxDropDownClass: null,
			comboboxDropDownItemClass: null,
			comboboxDropDownItemHoverClass: null,
			comboboxDropDownGroupItemHeaderClass: null,
			comboboxDropDownGroupItemContainerClass: null
		};
		
		// Option settings that determine the functionality of the control
		var optionSettings =
		{
			animationType: "slide",
			animationSpeed: "fast", // can be "fast", "slow", or a number in milliseconds
			width: 120
		};
		
		if (styles)
		{
			jQuery.extend(styleSettings, styles);
		}
		
		if (options)
		{
			jQuery.extend(optionSettings, options);
		}
		
		//#start public events
		
		///<summary>
		///	Called whenever the user selects a different item in the list.
		///	By default, event is not called if it has not been assigned.
		///</summary>
		this.combobox.onChange = callback || null;
		
		//#end public events
		
		//#start private functions
		
		///<summary>
		///	Returns the Combobox internal instance
		///</summary>
		function getInstance(context)
		{
			return context[0].internalCombobox;
		}

		// All make*Function(context) functions, create wrappers around the internal Combobox functions
		// and makes the function element specific.
		function makeRemoveFunction(context)
		{
			return function()
			{
				getInstance(context).remove();
			};
		}
		
		function makeUpdateFunction(context)
		{
			return function()
			{
				getInstance(context).update();
			}
		}
		
		function makeUpdateSelectionFunction(context)
		{
			return function()
			{
				getInstance(context).updateSelection();
			}
		}
		
		function makeAddRangeFunction(context)
		{
			return function(dataSource)
			{
				getInstance(context).addRange(dataSource);
			}
		}
					
		//#end private functions
		
		//#start exposed public methods
				
		// Add functionality to the combobox namespace
		jQuery.fn.extend(
			this.combobox,
			{
				addRange: makeAddRangeFunction(_context),
				remove: makeRemoveFunction(_context),
				update: makeUpdateFunction(_context),
				updateSelection: makeUpdateSelectionFunction(_context)
			});
			
		//#end exposed public methods
		
		return this.each(
			function()
			{
				// Create a new instance of the Combobox Class, intialising it with the DOM element to operate on and
				// attach the instance to the DOM
				this.internalCombobox = new ComboboxClass(this);
				
				// Call the instance to initialise itself
				this.internalCombobox.initialise();
				
				///<summary>
				///		a state-based class that is performs all functions necessary for the Combobox to work
				///</summary>
				function ComboboxClass(elementDOM)
				{
					//#start 'private' variables
					
					// This class can operate on N amount of elements depending how combobox() is called
					// for example $("select").combobox() could return multiple Selects.
					// This variable should always be a Select JQuery element.
					// TODO: Check if select control is used
					var _originalElementJQuery = jQuery(elementDOM);
					var _containerJQuery = null;
					var _containerDefaultStyle = "background-color:#fff;border-left: solid 2px #777;border-top: solid 2px #777;border-right: solid 1px #ccc;border-bottom: solid 1px #ccc;";
					var _containerEnforcedStyle = "padding:0;";
					var _dropDownListJQuery = null;
					var _dropDownListEnforcedStyle = "list-style-type:none;min-height:15px;padding-top:0;margin:0;overflow:auto";
					var _dropDownListDefaultStyle = "cursor:default;padding:2px;background:#fff;border-right:solid 1px #000;border-bottom:solid 1px #000;border-left:solid 1px #aaa;border-top:solid 1px #aaa;";
					var _dropDownListItemEnforcedStyle = "display:block;";
					var _dropDownListItemDefaultStyle = "cursor:default;padding-left:2px;font-weight:normal;font-style:normal;";
					var _dropDownListGroupItemContainerEnforcedStyle = "list-style-type:none;";
					var _dropDownListGroupItemContainerDefaultStyle = "padding-left:10px;margin-left:0;";
					var _dropDownListGroupItemHeaderEnforcedStyle = "";
					var _dropDownListGroupItemHeaderDefaultStyle = "font-style:italic;font-weight:bold;";
					var _dropdownListMaximumHeight = 300; // default max height: 300px
					var _valueContentContainerJQuery = null;
					var _valueContentContainerEnforcedStyle = "position:relative;overflow:hidden;";
					var _valueContentJQuery = null;
					var _valueContentEnforcedStyle = "float:left;position:absolute;cursor:default;overflow:hidden;";
					var _valueContentDefaultStyle = "padding-left:3px;";
					var _dropDownButtonJQuery = null;
					var _dropDownButtonDefaultStyle = "overflow:hidden;width:16px;height:18px;color:#000;background:#D6D3CE;font-family:arial;font-size:8px;cursor:default;text-align:center;vertical-align:middle;";
					var _dropDownButtonEnforcedStyle = "background-repeat:no-repeat;float:right;";
					var _dropDownButtonDefaultUnselectedStyle = "padding-left:0px;padding-top:1px;width:12px;height:13px;border-right:solid 2px #404040;border-bottom:solid 2px #404040;border-left:solid 2px #f0f0f0;border-top:solid 2px #f0f0f0";
					var _dropDownButtonDefaultSelectedStyle = "padding-left:1px;padding-top:3px;width:12px;height:13px;border:solid 1px #808080";
					var _dropDownButtonDefaultCharacter = "&#9660;"; //down-arrow character
					var _lastItemSelectedJQuery = null;
					var _lastItemHoveredJQuery = null;
					var _lastValue = null;
					var _downdownListPositionIsInverted = false;
					var _maximumItemLength = 0;
					var _dropDownListOffset = null;
					var _dropDownListHeight = 0;
					var _dropDownButtonImageDimension = null;
					var _valueContentContainerImageDimension = null;
					var _valueContentMaximumHeight = null;
					
					//#end 'private' variables
					
					//#start 'private' methods
					
					///<summary>
					/// Function extension to String.
					///	Replaces the placeholder tags '{0}...{n}' with the parameters based on ordinal position of the parameters
					///	Example: String.format("The quick {0} fox {2} over the lazy {1}.", "brown", "Dog", "jumps");
					///	Output:	The quick brown fox jumps over the lazy Dog.
					///</summary>
					String.format =
						function()
						{
							var currentString = null;
							if (arguments.length != 0)
							{
								currentString = arguments[0];
								for (var argumentIndex = 1; argumentIndex < arguments.length; argumentIndex++)
								{
									var modifiedString = new RegExp('\\{' + (argumentIndex - 1) + '\\}','gm');
									currentString = currentString.replace(modifiedString, arguments[argumentIndex]);
								}
							}
							
							return currentString;
						};
						
					///<summary>
					///	Returns the value from a string that has 'px' embedded.
					///	This function is normally used when working with CSS values.
					///	Note: returns null if the extension is not 'px', i.e. it may be 'em', 'pt', etc.
					///</summary>
					function getPixelValue(object)
					{
						var pixelValue = null;
						
						if (object)
						{
							if (object.substr(-2, 2) == "px")
							{
								pixelValue = object.substr(0, (object.length - 2));
							}
						}
						
						return pixelValue;
					}

					///<summary>
					///	Sets the width of an element taking into consideration any borders and padding.
					///	Works exactly like Internet Explorers Box Model, where the padding and border is considered
					//	part of the width. For the purposes of this control, it is required in certain circumstances.
					///	Example:
					///	 <div id="container" style="width: 150px; border:solid 2px #000"></div>
					///		jQuery('#container').width(); // 150px
					///		jQuery('#container').outerWidth(); // 154px (2px border on the left and right)
					///		setInnerWidth(jQuery('#container'), 120);
					///		jQuery('#container').width(); // 116px
					///		jQuery('#container').outerWidth(); // 120px (2px border on the left and right)
					///</summary>				
					function setInnerWidth(elementJQuery, width)
					{
						var differenceWidth = (elementJQuery.outerWidth() - elementJQuery.width());
						
						elementJQuery.width(width - differenceWidth);
					}
					
					///<summary>
					///	Sets the height of an element taking into consideration any borders and padding.
					///	Works exactly like Internet Explorers Box Model, where the padding and border is considered
					//	part of the height. For the purposes of this control, it is required in certain circumstances.			
					///</summary>				
					function setInnerHeight(elementJQuery, height)
					{
						var differenceheight = (elementJQuery.outerHeight() - elementJQuery.height());
						
						elementJQuery.height(height - differenceheight);
					}
					
					///<summary>
					/// Applies CSS styling from a string that contains multiple style styleSettings
					///	Example: "background-color:#fff;color:#0f0;border:solid 1px #00f;"
					///</summary>			
					function applyMultipleStyles(elementJQuery, multipleCSSStyles)
					{
						var stylePairArray = multipleCSSStyles.split(";");
						if (stylePairArray.length > 0)
						{
							for (var stylePairArrayIndex = 0; stylePairArrayIndex < stylePairArray.length; stylePairArrayIndex++)
							{
								var stylePair = stylePairArray[stylePairArrayIndex];
								var splitStylePair = stylePair.split(":");
								
								elementJQuery.css(splitStylePair[0], splitStylePair[1]);
							}
						}
					}
					
					///<summary>
					///	Calculates the width and height of an image from its URL
					///</summary>
					function getImageDimension(imageURL)
					{
						var dimension = new Object();
						dimension.width = 0;
						dimension.height = 0;
						
						sizingImageJQuery = jQuery("<img style='border:none;margin:0;padding:0;'></img>");
						sizingImageJQuery.attr("src", imageURL);
						
						_containerJQuery.append(sizingImageJQuery);
						
						dimension.width = sizingImageJQuery.width();
						dimension.height = sizingImageJQuery.height();
						
						sizingImageJQuery.remove();

						return dimension;
					}
				
					///<summary>
					///	Calculates the background image size for an JQuery element if it has a CSS background-image set.
					///</summary>
					function calculateIndividualImageDimension(jqueryElement)
					{
						var dimension = null;
						var backgroundImageURL = jqueryElement.css("background-image");
						// Depending on the browser, the URL of the background-image sometimes is padded with extra characters
						backgroundImageURL = backgroundImageURL.replace("url(", "", "gi");
						backgroundImageURL = backgroundImageURL.replace('"', '', "gi");
						backgroundImageURL = backgroundImageURL.replace('\"', '', "gi");
						backgroundImageURL = backgroundImageURL.replace(")", "", "gi");
						
						if (backgroundImageURL != "none")
						{
							dimension = getImageDimension(backgroundImageURL);
						}
						
						return dimension;
					}
					
					///<summary>
					///	Calculates the background image size for the value display and drop down button.
					///	These dimensions are used for control states, normal, pressed [, and hover]
					///</summary>
					function calculateImageDimensions()
					{
						_dropDownButtonImageDimension = calculateIndividualImageDimension(_dropDownButtonJQuery);
						_valueContentContainerImageDimension = calculateIndividualImageDimension(_valueContentContainerJQuery);
					}
					
					///<summary>
					///	Changes the visual of the value container to indicate a state.
					///	If the background-image is set and does not contain additional images for states,
					///	then the image is not changed for the different states. The Select for Safari works like this.
					///	The image states are stored below each other
					///	NOTE: This is different from the Drop Down Button where the images are stored side by side.
					/// for example
					///	A value container has a width of 275 pixels and a height of 35 pixels.
					///	The background-image is set to valuebackground.gif.
					///	valuebackground.gif is 70 pixels in height. The 'pressed' state image is at pixel height 35 in the image.
					///	States are:
					///	Normal = 0
					///	Pressed = 1
					///</summary>
					function setValueContentContainerState(state)
					{
						if (styleSettings.comboboxValueContentContainerClass)
						{
							// Only process buttomn states if a background-image has been set
							if (_valueContentContainerImageDimension != null)
							{
								var height = _valueContentContainerJQuery.height();
								var offset = (state * height);
								
								// Check if the image is higher than the set height.
								// This signifies that the image file contain different images below each other for different
								// states.
								if (_valueContentContainerImageDimension.height > offset)
								{
									var background_positionCSS = String.format("0px -{0}px", offset);
									_valueContentContainerJQuery.css("background-position", background_positionCSS);
								}
							}
						}
					}
					
					///<summary>
					///	Changes the visual of the drop down button to indicate a state.
					///	If the background-image is not set, then the default style is applied.
					///	If the background-image is set and does not contain additional images for states,
					///	then the image is not changed for the different states. The Select for Safari works like this.
					///	The image states are stored side by side: for example
					///	A drop-down button has a width of 16 pixel. The background-image is set to button.gif
					///	Button.gif is 32 pixels wide. The 'pressed' state image is at pixel position 16 in the image.
					///	States are:
					///	Normal = 0
					///	Pressed = 1
					///</summary>
					function setDropDownButtonState(state)
					{
						if (styleSettings.comboboxDropDownButtonClass)
						{
							// Only process buttomn states if a background-image has been set
							if (_dropDownButtonImageDimension != null)
							{
								var width = _dropDownButtonJQuery.width();
								var offset = (state * width);
								
								// Check if the image is wider than the set width.
								// This signifies that the image file contain different images next to each other for different
								// states.
								if (_dropDownButtonImageDimension.width > offset)
								{
									var background_positionCSS = String.format("-{0}px 0px", offset);
									_dropDownButtonJQuery.css("background-position", background_positionCSS);
								}
							}
						}
						else
						{
							var style = _dropDownButtonDefaultUnselectedStyle;
							
							if (state == 1)
							{
								style = _dropDownButtonDefaultSelectedStyle;
							}
							
							applyMultipleStyles(_dropDownButtonJQuery, style);
						}			
					}
					
					///<summary>
					///	Changes the visual appearance of the controls to represent the current state.
					///	States are:
					///	Normal = 0
					///	Pressed = 1
					///</summary>
					function setControlVisualState(state)
					{
						setValueContentContainerState(state);
						
						setDropDownButtonState(state);
					}
					
					///<summary>
					/// Builds the elements that make up the always visible portion of the control.
					///	The equivalent of a Textbox-type element.
					/// Also creates the DropDownButton
					///</summary>
					function buildValueContent()
					{
						// A container for the Display Value and DropDownButton. A container is required as the child elements
						// are floated
						var valueContentContainerHTML = "";
						if (styleSettings.comboboxValueContentContainerClass)
						{
							valueContentContainerHTML = String.format("<div class='{0}' style='{1}'></div>", styleSettings.comboboxValueContentContainerClass, _valueContentContainerEnforcedStyle);
						}
						else
						{
							valueContentContainerHTML = String.format("<div style='{0}'></div>", _valueContentContainerEnforcedStyle);
						}
						
						// Create the equivalent of the select 'textbox' where the current selected value is shown
						var valueContentHTML = "";
						if (styleSettings.comboboxValueContentClass)
						{
							valueContentHTML = String.format("<div class='{0}' style='{1}'></div>", styleSettings.comboboxValueContentClass, _valueContentEnforcedStyle);
						}
						else
						{
							valueContentHTML = String.format("<div style='{0}'></div>", _valueContentEnforcedStyle + _valueContentDefaultStyle);
						}
						
						var dropdownButtonHTML = "";
						if (styleSettings.comboboxDropDownButtonClass)
						{
							dropdownButtonHTML = String.format("<div class='{1}' style='{0}'></div>",_dropDownButtonEnforcedStyle, styleSettings.comboboxDropDownButtonClass);
						}
						else
						{
							dropdownButtonHTML = String.format("<div style='{0}'>{1}</div>", (_dropDownButtonEnforcedStyle + _dropDownButtonDefaultStyle), _dropDownButtonDefaultCharacter);
						}
						
						_valueContentJQuery = jQuery(valueContentHTML);
						_dropDownButtonJQuery = jQuery(dropdownButtonHTML);
						_valueContentContainerJQuery = jQuery(valueContentContainerHTML);
						
						_valueContentContainerJQuery.appendTo(_containerJQuery);
						_valueContentJQuery.appendTo(_valueContentContainerJQuery);
						_dropDownButtonJQuery.appendTo(_valueContentContainerJQuery);
						
						calculateImageDimensions();
						
						_valueContentMaximumHeight = getPixelValue(_valueContentJQuery.css("max-height"));
					
						// Set control to normal state
						setControlVisualState(0);
					}
					
					///<summary>
					///	Build a drop down list element populating it will values, text, styles and class
					///	depending on the source value type. The source value (childJQuery) can be an option or
					///	and optgroup element.
					///</summary>
					function buildDropDownItem(childJQuery)
					{
						var dataItemHTML = "";
						var dataItemClass = null;
						var dataItemText = "";
						var dataItemTitle = "";
						var dataItemValue = null;
						var dataItemStyle = "";
						var dataItemType = "option";
						var childElement = childJQuery[0];
						
						if (childElement.title)
						{
							if (childElement.title != "")
							{
								dataItemTitle = childElement.title;
							}
						}
						
						if (childJQuery.is('option'))
						{
							if (childElement.dataText)
							{
								dataItemText = childElement.dataText;
							}
							else
							{
								dataItemText = childJQuery.text();
							}
							dataItemValue = childJQuery.val();
							
							if (styleSettings.comboboxDropDownItemClass)
							{
								dataItemClass = styleSettings.comboboxDropDownItemClass;
								dataItemStyle = _dropDownListItemEnforcedStyle;
							}
							else
							{
								dataItemStyle = (_dropDownListItemEnforcedStyle + _dropDownListItemDefaultStyle);
							}
							
							if (dataItemClass)
							{						
								dataItemHTML = String.format("<li style='{0}' class='{1}'>{2}</li>", dataItemStyle, dataItemClass, dataItemText);
							}
							else
							{
								dataItemHTML = String.format("<li style='{0}'>{1}</li>", dataItemStyle, dataItemText);
							}
							
						}
						else
						{
							if (childJQuery[0].dataText)
							{
								dataItemText = childJQuery[0].dataText;
							}
							else
							{
								dataItemText = childJQuery.attr('label');
							}
							dataItemValue = childJQuery.attr('class');
							dataItemType = "optgroup";
							
							if (styleSettings.comboboxDropDownGroupItemHeaderClass)
							{
								dataItemClass = styleSettings.comboboxDropDownGroupItemHeaderClass;
								dataItemStyle = _dropDownListGroupItemHeaderEnforcedStyle;
							}
							else
							{
								dataItemStyle = (_dropDownListGroupItemHeaderEnforcedStyle + _dropDownListGroupItemHeaderDefaultStyle);
							}
							
							if (dataItemClass)
							{						
								dataItemHTML = String.format("<li><span style='{0}' class='{1}'>{2}</span></li>", dataItemStyle, dataItemClass, dataItemText);
							}
							else
							{
								dataItemHTML = String.format("<li><span style='{0}'>{1}</span></li>", dataItemStyle, dataItemText);
							}
						}
						
						var dataItemJQuery = jQuery(dataItemHTML);
						
						// The element's style is set to inline for the calculation of the true width
						// The element is then reset to its enforced style (display:block) later
						dataItemJQuery.css("display", "inline");
						// Store the value with the DOMElement which is persisted with the Browser
						dataItemJQuery[0].dataText = dataItemText;
						dataItemJQuery[0].dataValue = dataItemValue;
						dataItemJQuery[0].dataType = dataItemType;
						if (dataItemTitle == "")
						{
							dataItemTitle = dataItemText
						}
						dataItemJQuery[0].title = dataItemTitle;
						
						return dataItemJQuery;
					}
					
					///<summary>
					///	Recusively build the drop down list elements based on the options and optgroups contained
					///	with the original Select element
					///</summary>
					function recursivelyBuildList(parentJQuery, childrenOptionsJQuery)
					{
						childrenOptionsJQuery.each(
							function()
							{
								var childJQuery = jQuery(this);
								var builtDropDownItemJQuery = buildDropDownItem(childJQuery);
								parentJQuery.append(builtDropDownItemJQuery);
								
								// Calculate the true width of the item taking into consideration the offset from the left-edge
								// of the drop-down list.
								// Get the left offset of the DropDown list container and subtract that from the builtDropDownItemJQuery left offset
								//	to get the distance the builtDropDownItemJQuery is from its container
								var offsetLeft = builtDropDownItemJQuery.offset().left;
								
								offsetLeft -= _dropDownListOffset.left;
								
								if (offsetLeft < 0)
								{
									offsetLeft = 0;
								}
								
								var width = (offsetLeft + builtDropDownItemJQuery.outerWidth());
								if (width > _maximumItemLength)
								{
									_maximumItemLength = width;
								}
								
								// Set the enforced style of display:block after the width has been calculated.
								applyMultipleStyles(builtDropDownItemJQuery, _dropDownListItemEnforcedStyle);
								
								if (childJQuery.is('optgroup'))
								{
									var dataGroupItemHTML = "";
									if (styleSettings.comboboxDropDownGroupItemContainerClass)
									{
										dataGroupItemHTML = String.format("<ul style='{0}' class='{1}'></ul>", _dropDownListGroupItemContainerEnforcedStyle, styleSettings.comboboxDropDownGroupItemContainerClass);
									}
									else
									{
										dataGroupItemHTML = String.format("<ul style='{0}'></ul>", (_dropDownListGroupItemContainerEnforcedStyle + _dropDownListGroupItemContainerDefaultStyle));
									}
									
									var dataGroupItemJQuery = jQuery(dataGroupItemHTML);
									builtDropDownItemJQuery.append(dataGroupItemJQuery);
									
									// If not an option, then the child of a Select must be an optgroup element
									recursivelyBuildList(dataGroupItemJQuery, childJQuery.children());
								}
							});
					}
					
					///<summary>
					/// Creates an unordered list of values from the original Select control
					///</summary>
					function buildDropDownList()
					{
						var originalElementChildrenJQuery = _originalElementJQuery.children();
						_lastItemSelectedJQuery = null;
						_lastValue = null;

						// If the Drop Down List container already exists, recreate only the items,
						// else create the container and the items as well.
						if (_dropDownListJQuery)
						{
							// Clear out any existing children elements
							_dropDownListJQuery.empty();
						}
						else
						{
							var dropDownHTML = "";
							if (styleSettings.comboboxDropDownClass)
							{
								dropDownHTML = String.format("<ul class='{0}' style='{1}'></ul>", styleSettings.comboboxDropDownClass, _dropDownListEnforcedStyle);
							}
							else
							{
								dropDownHTML = String.format("<ul style='{0}'></ul>", (_dropDownListEnforcedStyle + _dropDownListDefaultStyle));
							}
							
							_dropDownListJQuery = jQuery(dropDownHTML);
							// Create the equivalent of the drop down list where the all the values are shown
							_dropDownListJQuery.appendTo(_containerJQuery);
							
							// Enable the Drop Down List to be able to receive focus and key events
							_dropDownListJQuery.attr("tabIndex", 0);
						}
						
						// Create the internal list of values if they exist
						if (originalElementChildrenJQuery.length > 0)
						{
							_maximumItemLength = 0;
							_dropDownListOffset = _dropDownListJQuery.offset();
								
							recursivelyBuildList(_dropDownListJQuery, originalElementChildrenJQuery);
						}
						
						// Check if the max-height has been set as a CSS setting
						// If it has, determine if the current height of the dropdown list does not exceed it and if 
						// it does, reset the height to match the setting.
						var maximumHeight = getPixelValue(_dropDownListJQuery.css("max-height"));
										
						// Only use the maximum height if it has been set correctly
						if (maximumHeight)
						{
							_dropdownListMaximumHeight = maximumHeight;
						}
						
						var dropdownListHeight = _dropDownListJQuery.height();
						if (dropdownListHeight > _dropdownListMaximumHeight)
						{
							_dropDownListJQuery.height(_dropdownListMaximumHeight);
						}
						
						// Store the height because the browser flashes (FF) when accessing this function
						_dropDownListHeight = _dropDownListJQuery.height();
					}
					
					///<summary>
					///	Adjust the width of the DropDown list based on the widest item or the set width (options), whichever
					///	is larger.
					///</summary>
					function updateDropDownListWidth()
					{
						//Drop down list element
						var dropdownListWidth = _containerJQuery.outerWidth();
						if (dropdownListWidth < _maximumItemLength)
						{
							dropdownListWidth = _maximumItemLength;
						}
						
						_dropDownListJQuery.width(dropdownListWidth);
					}
					
					///<summary>
					/// Repositions the display value based on height of the element.
					///	Note: the height will only have meaning if the display value element has text
					///</summary>
					function positionDisplayValue()
					{
						// Set the height to the default and allow it to fill the height to accomodate the content
						_valueContentJQuery.height("auto");
						var displayValueHeight = _valueContentJQuery.outerHeight();
						var displayContainerHeight = _valueContentContainerJQuery.height();
						
						// Check if the developer wants to clip the content within a region
						if (_valueContentMaximumHeight)
						{
							// Set the height of the content to the maximumContentHeight if it is less
							// than the current height of the content
							if (_valueContentMaximumHeight < displayValueHeight)
							{
								displayValueHeight = _valueContentMaximumHeight;
								_valueContentJQuery.height(displayValueHeight);
							}
						}
						
						var difference = ((displayContainerHeight - displayValueHeight) / 2);
						
						if (difference < 0)
						{
							difference = 0;
						}
						
						//TODO: add other alignments for the user, such as left, top, middle, bottom, etc
						_valueContentJQuery.css("top", difference);
					}
					
					///<summary>
					///	Applies custom layout position and sizing to the controls
					///</summary>
					function applyLayout()
					{
						_containerJQuery.width(optionSettings.width);
						
						// Removes any units and retrieves only the value of width
						var controlWidth = _containerJQuery.width();
						setInnerWidth(_valueContentContainerJQuery, controlWidth);
						
						var displayValueWidth = (_valueContentContainerJQuery.width() - _dropDownButtonJQuery.outerWidth());
						setInnerWidth(_valueContentJQuery, displayValueWidth);
						var dropDownButtonHeight = _dropDownButtonJQuery.outerHeight();
						setInnerHeight(_valueContentContainerJQuery, dropDownButtonHeight);
						
						_dropDownListJQuery.css("position", "absolute");
						_dropDownListJQuery.css("z-index", "20000");
						
						updateDropDownListWidth();
						
						// Position the drop down list correctly, taking the main display control border into consideration
						var currentLeftPosition = _dropDownListJQuery.offset().left;
						var leftPosition = (currentLeftPosition - (_containerJQuery.outerWidth() - _containerJQuery.width()));
						_dropDownListJQuery.css("left", leftPosition + 1);
						
						_dropDownListJQuery.hide();
					}

					///<summary>
					///		Sets the value both internally and visually to the user
					///</summary>
					function setContentDisplay()
					{
						var valueHasChanged = false;
						var originalElement = _originalElementJQuery[0];
						var dataItemJQuery;
						
						if (originalElement.length > 0)
						{
							//var selectedText = originalElement[originalElement.selectedIndex].text;
							var selectedDropDownListItemJQuery = jQuery("li[@dataValue='" + _originalElementJQuery.val() + "']", _dropDownListJQuery);
							
							_valueContentJQuery.html(selectedDropDownListItemJQuery[0].dataText);
							_valueContentJQuery.attr("title", selectedDropDownListItemJQuery[0].title);
							
							// Reposition the display value based on height of the element after the text has changed
							positionDisplayValue();
							
							if (_lastValue)
							{
								if (_lastValue != _originalElementJQuery.val())
								{
									valueHasChanged = true;
								}
							}
							
							_lastValue = _originalElementJQuery.val();
							
							//  If the selected value has changed since the last click, fire the onChange event
							if (valueHasChanged)
							{
								// Check if the onChange event is being consumed, otherwise it will be undefined
								if (_context.combobox.onChange)
								{
									_context.combobox.onChange();
								}
							}
							
							// If _lastItemSelectedJQuery has been set, remove the highlight from it, before setting it to the current
							// value
							if (_lastItemSelectedJQuery)
							{
								toggleItemHighlight(_lastItemSelectedJQuery, false);
							}
							
							// Find the DropDown Item Element that corresponds to the current value in the Select element
							_lastItemSelectedJQuery = selectedDropDownListItemJQuery;
							
							toggleItemHighlight(_lastItemSelectedJQuery, true);
						}
					}
					
					///<summary>
					///	Forces the a drop down list item to be visible on screen.
					///	This applies to containers that have scrollbars and elements within it
					///	are out of vision.
					///	Only scrolls an item into place if it not visible on screen.
					///</summary>
					function scrollDropDownListItemIntoView(dropdownListItemJQuery)
					{
						//TODO: Not working correctly in IE.
						// Moving up does not immediately show the hidden item above
						if (dropdownListItemJQuery)
						{
							if (_dropDownListHeight >= _dropdownListMaximumHeight)
							{
								var offset = dropdownListItemJQuery.offset();

								// Only scroll if the item is below the height of the ddl
								// or above the top of it or the height of a DDL item
								if (
										(offset.top > _dropDownListHeight)
										||
										(offset.top <= dropdownListItemJQuery.outerHeight())
									 )
								{
									dropdownListItemJQuery[0].scrollIntoView();
								}
							}
						}			
					}
					
					///<summary>
					///	Highlights/Unhighlights a specific option.
					///	If a class is not set, then the background and foreground colours are inverted
					///</summary>
					function toggleItemHighlight(elementJQuery, isHighlighted)
					{
						if (elementJQuery)
						{
							if (styleSettings.comboboxDropDownItemHoverClass)
							{
								if (isHighlighted)
								{
									elementJQuery.addClass(styleSettings.comboboxDropDownItemHoverClass);
								}
								else
								{
									elementJQuery.removeClass(styleSettings.comboboxDropDownItemHoverClass);
								}
							}
							else
							{
								if (isHighlighted)
								{
									elementJQuery.css("background", "#000");
									elementJQuery.css("color", "#fff");
								}
								else
								{
									elementJQuery.css("background", "");
									elementJQuery.css("color", "");
								}
							}
						}
					}

					///<summary>
					///	Builds the Outermost control and swaps out the original Select element.
					///	The Select element then becomes an hidden control within.
					///</summary>
					function buildContainer()
					{
						var containerHTML = "";
						if (styleSettings.comboboxContainerClass)
						{
							containerHTML = String.format("<div class='{0}' style='{1}'></div>", styleSettings.comboboxContainerClass, _containerEnforcedStyle);
						}
						else
						{
							containerHTML = String.format("<div style='{0}' style='{1}'></div>", _containerDefaultStyle, _containerEnforcedStyle);
						}
						_containerJQuery = jQuery(containerHTML);
						_originalElementJQuery.before(_containerJQuery);
						_containerJQuery.append(_originalElementJQuery);
						_originalElementJQuery.hide();
						
						// Allow the custom jquery.combobox be able to receive focus and key events
						_containerJQuery.attr("tabIndex", 0);
					}
					
					///<summary>
					///	Converts an existing Select element to a JQuery.combobox.
					///	The Select element is kept and updated accordingly, but visually is represented
					///	by other richer HTML elements
					///</summary>
					this.initialise =
						function ()
						{
							buildContainer();
							
							buildValueContent();
							
							buildDropDownList();
							
							applyLayout();
							
							bindEvents();
							
							setContentDisplay();
						};
					
					///<summary>
					///	Focus must be set to the DropDown list element only after it has shown.
					///	This is due to IE executing the Blur event before the list has immediately shown
					///</summary>
					function postDropDownListShown()
					{
						_dropDownListJQuery.focus();
						scrollDropDownListItemIntoView(_lastItemSelectedJQuery);
					}

					///<summary>
					///	Focus set to the Combobox Container
					///</summary>
					function setAndBindContainerFocus()
					{
						_containerJQuery.focus();
						bindContainerClickEvent();
					}
					
					///<summary>
					///	Slides up the DropDownlist when it is to be placed above the CB
					///</summary>
					function slideUp(newTop)
					{
						_dropDownListJQuery.animate(
							{
								height: "toggle",
								top: newTop
							},
							optionSettings.animationSpeed,
							postDropDownListShown);
					}
					
					///<summary>
					///	Slides closed the DropDownlist when it is placed above the CB.
					///	Binds the CB Container click event after the DDL is hidden to avoid a bug in IE
					///	where the click event fires re-opening the DDL.
					///</summary>
					function slideDown(newTop)
					{
						_dropDownListJQuery.animate(
							{
								height: "toggle",
								opacity: "toggle",
								top: newTop
							},
							optionSettings.animationSpeed,
							setAndBindContainerFocus);
					}
					
					///<summary>
					///	Toggles the slide with a fade and returning execution to the callback function when down
					///</summary>
					function slideToggle(callback)
					{
						_dropDownListJQuery.animate(
							{
								height: "toggle",
								opacity: "toggle"
							},
							optionSettings.animationSpeed,
							callback);
					}
					
					///<summary>
					///	Get the proposed top position of the drop down list container.
					///	Also sets whether the drop down list is inverted. Inverted means that the
					///	list is shown above the container as opposed to the normal position of below the combobox 
					///	container
					///</summary>
					function getDropDownListTop()
					{
						var comboboxTop = _containerJQuery.position().top;
						var dropdownListHeight = _dropDownListJQuery.outerHeight();
						var comboboxBottom = (comboboxTop + _containerJQuery.outerHeight());
						var windowScrollTop = jQuery(window).scrollTop();
						var windowHeight = jQuery(window).height();	
						var availableSpaceBelow = (windowHeight - (comboboxBottom - windowScrollTop));
						var dropdownListTop;

						// Set values to display dropdown list below combobox as default				
						dropdownListTop = comboboxBottom;
						_downdownListPositionIsInverted = false;

						// Check if there is enough space below to display the full height of the drop down list
						if (availableSpaceBelow < dropdownListHeight)
						{
							// There is no available space below the combobox to display the dropdown list
							// Check if there is available space above. If not, then display below as default
							if ((comboboxTop - windowScrollTop)> dropdownListHeight)
							{
								// There is space above
								dropdownListTop = (comboboxTop - dropdownListHeight);
								_downdownListPositionIsInverted = true;
							}
						}
						
						return dropdownListTop;
					}
					
					///<summary>
					///	Hides/Shows the list of values.
					///	The method of display or hiding is specified as optionSettings.animationType.
					///	This method also changes the button state
					///</summary>					
					function toggleDropDownList(isShown)
					{
						if (isShown)
						{
							if (_dropDownListJQuery.is(":hidden"))
							{
								// Remove the click event from the container because when the dropdown list is shown
								// and the container is clicked, the dropdownlist blur event is fired which hides the control
								// and the container click is fired after which will show the list again (error);
								unbindContainerClickEvent();
								
								// Remove the highlight from the last item hovered before the DDL was retracted
								toggleItemHighlight(_lastItemHoveredJQuery, false);
								
								// When the DropDown list is shown, highlist the current value in the list
								toggleItemHighlight(_lastItemSelectedJQuery, true);
				
								setControlVisualState(1);
								
								var dropdownListTop = getDropDownListTop();
								_dropDownListJQuery.css("top", dropdownListTop);
								_dropDownListJQuery.css("left", _containerJQuery.offset().left);
								
								switch (optionSettings.animationType)
								{
									case "slide":
										if (_downdownListPositionIsInverted)
										{
											var comboboxTop = _containerJQuery.position().top;
											var containerHeight = _containerJQuery.outerHeight();

											_dropDownListJQuery.css("top", (comboboxTop - containerHeight));

											slideUp(dropdownListTop);
										}
										else
										{
											slideToggle(postDropDownListShown);
										}
										break;
										
									case "fade":
										_dropDownListJQuery.fadeIn(optionSettings.animationSpeed, postDropDownListShown);
										break;
										
									default:
										// Bug: if show() is used and postDropDownListShown() is immediately after,
										// the focus hides the DropDownList. Show(1, xxx) uses a callback which seems to work
										_dropDownListJQuery.show(1, postDropDownListShown);
								}
							}
						}
						else
						{
							if (_dropDownListJQuery.is(":visible"))
							{
								setControlVisualState(0);
								
								switch (optionSettings.animationType)
								{
									case "slide":
										if (_downdownListPositionIsInverted)
										{
											comboboxTop = _containerJQuery.position().top;
											dropdownListHeight = _dropDownListJQuery.height();

											slideDown(comboboxTop - _containerJQuery.outerHeight());
										}
										else
										{
											slideToggle(setAndBindContainerFocus);
										}
										break;
										
									case "fade":
										_dropDownListJQuery.fadeOut(optionSettings.animationSpeed, setAndBindContainerFocus);
										break;
										
									default:
										_dropDownListJQuery.hide();
										setAndBindContainerFocus();
								}
							}
						}
					}
					
					///<summary>
					///	Sets the internal select element (original) to match the visually changes made by the user.
					///	This ensures that any legacy code working with the original select is kept up to date with changes
					/// Either selectedIndex or selectedValue can be used, not both at the same time.
					///</summary>
					function setOriginalSelectItem(selectedIndex, selectedValue)
					{
						var originalElementDOM = _originalElementJQuery[0];
						
						if (selectedValue == null)
						{
							originalElementDOM.selectedIndex = selectedIndex;
						}
						else
						{
							originalElementDOM.value = selectedValue;
						}
						
						// Fire the OnChange event for the original select element
						if (originalElementDOM.onchange)
						{
							originalElementDOM.onchange();
						}
						
						setContentDisplay();
					}

					///<summary>
					///	Selects a value from the list of options from the original Select options.
					///	Does not use JQuery Selectors ':last' and ':first' because they take optgroup elements into
					///	account.
					///</summary>					
					function selectValue(subSelector)
					{
						var originalElement = _originalElementJQuery[0];
						var currentIndex = originalElement.selectedIndex;
						var newIndex = -1;
						// {select}.length returns the array size of the options. Does not count optgroup elements
						var optionCountZeroBased = originalElement.length - 1;
						
						switch (subSelector)
						{
							case ":next":
								newIndex = currentIndex + 1;
								if (newIndex > optionCountZeroBased)
								{
									newIndex = optionCountZeroBased;
								}
								break;
							
							case ":previous":
								newIndex = currentIndex - 1;
								if (newIndex < 0)
								{
									newIndex = 0;
								}

								break;
								
							case ":first":
								newIndex = 0;
								
								break;
								
							case ":last":
								newIndex = optionCountZeroBased;
								
								break;
						}

						setOriginalSelectItem(newIndex, null);
						
						scrollDropDownListItemIntoView(_lastItemSelectedJQuery);
					}
					
					///<summary>
					///	Returns true if the DropDownList visible on screen, else false
					///</summary>
					function isDropDownVisible()
					{
						return _dropDownListJQuery.is(":visible");
					}
					
					///<summary>
					/// Bind all items to mouse events except for UL elements
					/// and LI elements that are option group labels
					///</summary>			
					function bindItemEvents()
					{
						jQuery("li", _dropDownListJQuery).not("ul").not("span").not("[@dataType='optgroup']").each(
							function()
							{
								var itemJQuery = jQuery(this);
								itemJQuery.click(
									function(clickEvent)
									{
										// Stops the click event propagating to the Container and the Container.onClick firing
										clickEvent.stopPropagation();
										
										dropdownList_onItemClick(itemJQuery);
									});
								
								itemJQuery.mouseover(
									function()
									{
										dropdownList_onItemMouseOver(itemJQuery);
									});
									
								itemJQuery.mouseout(
									function()
									{
										dropdownList_onItemMouseOut(itemJQuery);
									});
							});			
					}

					///<summary>
					///		Bind the dropdown list control blur event to a function
					///</summary>
					function bindBlurEvent()
					{
						_dropDownListJQuery.blur(
							function(blurEvent)
							{
								blurEvent.stopPropagation();
								
								dropdownList_onBlur();
							});
					}
					
					///<summary>
					///	Bind the click event of the container to a function
					///</summary>
					function bindContainerClickEvent()
					{
						_containerJQuery.click(
							function()
							{
								container_onClick();
							});
					}

					///<summary>
					///	Remove the binding of a custom function from the container's click event
					///</summary>
					function unbindContainerClickEvent()
					{
						_containerJQuery.unbind("click");
					}
								
					///<summary>
					///		Bind this control to the events to custom functions
					///</summary>
					function bindEvents()
					{
						_containerJQuery.keydown(
							function(keyEvent)
							{
								keyEvent.preventDefault();
								container_onKeyDown(keyEvent)
							});
							
						bindContainerClickEvent();
							
						bindBlurEvent();
							
						bindItemEvents();
					}				
					
					//#end 'private' functions
					
					//#start private events
					
					///<summary>
					///	If the drop down list is retracted, it is shown,
					///	else if shown, it is retracted
					///</summary>
					function container_onClick()
					{
						if (_dropDownListJQuery.is(":hidden"))
						{
							toggleDropDownList(true);
						}
						else
						{
							toggleDropDownList(false);
						}
					}
					
					///<summary>
					///	Fires when the drop down list loses focus.
					///	On Blur, the drop down list is retracted
					///</summary>
					function dropdownList_onBlur()
					{
						if (_dropDownListJQuery.is(":visible"))
						{
							toggleDropDownList(false);
						}
					}
					
					///<summary>
					///	Retrieves the value of the item clicked, sets the content to that value
					///	and retracts the drop-down list
					///</summary>
					function dropdownList_onItemClick(itemJQuery)
					{
						setOriginalSelectItem(null, itemJQuery[0].dataValue); 
						
						toggleDropDownList(false);
					}
					
					///<summary>
					///	Highlights the Drop Down List item currently under the mouse.
					///	Removes the highlist from the previous selected item as well.
					///</summary>
					function dropdownList_onItemMouseOver(itemJQuery)
					{
						// An item may be selected from the previous selection and will require
						// to be set to normal.
						// TODO: find a better method of matching _lastItemSelectedJQuery to itemJQuery and optimising the removal
						// of the class, instead of removing it consistently
						toggleItemHighlight(_lastItemSelectedJQuery, false);
						
						toggleItemHighlight(_lastItemHoveredJQuery, false);
						
						toggleItemHighlight(itemJQuery, true);
					}
					
					///<summary>
					///		Removes the highlight from the selected item
					///</summary>
					function dropdownList_onItemMouseOut(itemJQuery)
					{
						//toggleItemHighlight(itemJQuery, false);
						_lastItemHoveredJQuery = itemJQuery;
					}
					
					///<summary>
					///	Handles the keyboard navigation aspect of the combobox.
					///	Note: Does not jump to item if the first letter is pressed.
					///</summary>
					//TODO: Correctly support page-up and page-down, esp. with scrolling
					function container_onKeyDown(keyEvent)
					{
						switch (keyEvent.which)
						{
							case 33:
								//Page Up
							case 36:
								//Home
								selectValue(":first");
								break;
							
							case 34:
								//Page Down
							case 35:
								//End
								selectValue(":last");
								break;

							case 37:
								//Left
								selectValue(":previous");
								break;
								
							case 38:
								//Up
								if (keyEvent.altKey)
								{
									// alt-up
									// If DDL is hidden, then it is shown and vice-versa
									toggleDropDownList(!(isDropDownVisible()));
								}
								else
								{
									selectValue(":previous");
								}
								break;

							case 39:
								//Right
								selectValue(":next");
								break;
								
							case 40:
								//Down
								if (keyEvent.altKey)
								{
									// alt-down
									// If DDL is hidden, then it is shown and vice-versa
									toggleDropDownList(!(isDropDownVisible()));
								}
								else
								{
									selectValue(":next");
								}
								break;
								
							case 27:
							case 13:
								// Escape
								toggleDropDownList(false);
								break;

							case 9:
								// Tab
								//TODO: Support alt-tab
								//TODO: Does not truly leave the Combobox if the DropDown is visible
								_dropDownListJQuery.blur();
								
								// This is required in Internet Explorer as the blur() order is different
								jQuery(window)[0].focus();
								
								break;
						}
					}
					//#end private events
					
					//#start public methods
					
					///<summary>
					///	Updates the combobox with the current selected item.
					///	This function is called if the original Select element selection has been changed
					///</summary>
					this.updateSelection = 
						function()
						{
							setContentDisplay();
						};
						
					///<summary>
					///	The Drop Down List Container will already have been created.
					///	This function recreates the items and binds the events to them.
					///	Thereafter, the current selection is set.
					///</summary>
					this.update =
						function()
						{
							buildDropDownList();
							updateDropDownListWidth();
							bindItemEvents();
							setContentDisplay();
						};
						
					///<summary>
					///	Removes the jquery.combobox leaving the original select element
					///</summary>					
					this.remove =
						function()
						{
							//Move the original element to a position before the jquery.combobox			
							_containerJQuery.before(_originalElementJQuery);
							_containerJQuery.remove();
							
							// Remove the internal object property from the DOM
							//TODO: next statement does not work in Internet Explorer 6.
							//delete _originalElementJQuery[0].internalCombobox;
							_originalElementJQuery[0].internalCombobox = null;
							
							_originalElementJQuery.show();
						};
						
					///<summary>
					///	Adds a range of options into the combobox.
					///	Using this function bypasses the browsers restriction of adding
					///	html as text values. This allows customisation of the display text
					///	Format of dataSource
					///	[
					///		{
					///			value: object, // usual a unique string value
					///			text: object,  // can be normal text or html
					///			title: string  // optional
					///		}
					///	]
					///	Note: Still in development
					///</summary>
					this.addRange =
						function(dataSource)
						{
							if (dataSource)
							{
								var originalOptions = _originalElementJQuery[0].options;
								var optionTotal = originalOptions.length;
								for (optionIndex in dataSource)
								{
									var option = dataSource[optionIndex];
									var optionElement = document.createElement("option");
									optionElement.value = option.value;
									optionElement.text = option.text;
									// Store the raw text data. Option.text removes all HTML content
									optionElement.dataText = option.text;
									if (option.title)
									{
										optionElement.title = option.title;
									}
									
									originalOptions[optionTotal + optionIndex] = optionElement;
								}
								
								_originalElementJQuery.combobox.update();
							}
						};
					
					//#end public methods
					
				}
			});
	}
/*
TODOS:
- look to moving functions to outside the context and use a state based object to track individual elements [0]
*/
