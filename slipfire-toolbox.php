<?php

/*
Plugin Name: SlipFire Toolbox
Plugin URI: http://slipfire.com
Description: SlipFire functions and CSS. Install in mu-plugins
Version: 4.9.17
Author: SlipFire
Author URI: http://slipfire.com/
Plugin Type: Piklist
License: GPLv2
*/

/*
  This software is distributed under the GNU General Public License, Version 2,
  June 1991. Copyright (C) 1989, 1991 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

  *******************************************************************************
  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
  *******************************************************************************
*/


if (!defined('ABSPATH'))
{
  exit;
}


define('SLIPFIRE_TOOLBOX_ASSETS_VERSION', '4.9.11');

// Load main class
include_once('slipfire-toolbox/includes/class-slipfire.php');

// Load security class
include_once('slipfire-toolbox/includes/class-slipfire-security.php');

// Load theme class
include_once('slipfire-toolbox/includes/class-slipfire-theme.php');

if (is_admin())
{
	// Load admin class
  include_once('slipfire-toolbox/includes/class-slipfire-admin.php');
}

class SlipFire_Toolbox
{
  public static function base_dir_url()
	{
		return plugins_url('slipfire-toolbox/', __FILE__);
	}
}
