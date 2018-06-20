<?php
namespace Assets\Controller;

use Cake\Controller\Controller;

/**
 * Assets Controller
 *
 * @property \Assets\Model\Table\AssetsTable $Assets
 *
 * @method \Assets\Model\Entity\Asset[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AssetsController extends AppController
{

    /**
     * Download method
     *
     * @param string|null $id Asset id.
     * @return static
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function download($id = null)
    {
        $asset = $this->loadModel()->get($id);

        // TODO Get file path to be read from settings
        $file = ROOT . DS . $asset->dir . $asset->file_name;

        $response = $this->response
            ->withModified(filemtime($file));

        if ($response->checkNotModified($this->request)) {
            return $response;
        }

        $extension = pathinfo($file, PATHINFO_EXTENSION);
        return $response->withFile($file)
            ->withType(strtolower($extension));
    }
}
