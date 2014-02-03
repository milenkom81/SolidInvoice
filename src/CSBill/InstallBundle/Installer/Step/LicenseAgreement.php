<?php
/*
 * This file is part of the CSBill package.
 *
 * (c) Pierre du Plessis <info@customscripts.co.za>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CSBill\InstallBundle\Installer\Step;

use CSBill\InstallBundle\Form\Step\LicenseAgreementForm;
use Symfony\Component\Finder\Finder;
use CSBill\InstallBundle\Installer\AbstractFormStep;

class LicenseAgreement extends AbstractFormStep
{
    /**
     * @return LicenseAgreementForm
     */
    public function getForm()
    {
        return new LicenseAgreementForm();
    }

    /**
     * @return array
     */
    public function getFormData()
    {
        $license = '';

        $root_dir = dirname($this->get('kernel')->getRootDir());

        $finder = new Finder();
        $finder->files()->in($root_dir)->depth('== 0')->filter(function (\SplFileInfo $file) {
            $extension = pathinfo($file->getFilename(), PATHINFO_EXTENSION);

            if ($extension !== '') {
                return false;
            }
        });

        foreach ($finder as $file) {
            if (strtolower($file->getBasename()) === 'license') {
                $license = $file->getContents();
                break;
            }
        }

        return array(
            'license_info' => $license
        );
    }
}
