<?php
/**
 * @package Profiler Fields for Joomla! 2.5
 * @version $Id$
 * @author Harold Prins
 * @copyright (C) 2011-2013 Harold Prins
 * @license GNU/GPLv2 http://www.gnu.org/licenses/gpl-2.0.html
 *  
 * Profiler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 * along with Profiler.  If not, see <http://www.gnu.org/licenses/gpl-2.0.html>.
*/
// No direct access
defined('_JEXEC') or die;

class PffieldsViewCategories extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;
	protected $extension;

	public function display($tpl = null)
	{
		// Initialise variables.
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		
		$prefix = JRequest::getCmd('prefix', '');
		$this->extension = JRequest::getCmd('extension', 'com_pffields') . $prefix;
		
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/pffields.php';
		$extension = JRequest::getCmd('extension', 'com_pffields');

		$canDo	= PffieldsHelper::getActions();

		JToolBarHelper::title(JText::_('COM_PFFIELDS_VIEW_CATEGORIES'), 'cpanel');
		
		if ($canDo->get('core.create')) {
			JToolBarHelper::addNew('category.add','JTOOLBAR_NEW');
		}

		if (($canDo->get('core.edit'))) {
			JToolBarHelper::editList('category.edit','JTOOLBAR_EDIT');
		}
		
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'categories.delete','JTOOLBAR_DELETE');
			JToolBarHelper::divider();
		}
				
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences($extension);
		}
		
		JToolBarHelper::divider();
		$url = "http://www.haroldprins.nl/wiki/index.php?title=Profiler";
		JToolBarHelper::help("", "", $url);
		
		JHtmlSidebar::setAction('index.php?option=com_pffields&view=fields');
		
		JHtmlSidebar::addFilter(
			JText::_('COM_PFFIELDS_CATEGORIES_FILTER_TYPE'),
			'filter_type',
			JHtml::_('select.options', PffieldsHelper::getTypeOptions(), 'value', 'text', $this->state->get('filter.type'))
		);
		
	}
}
