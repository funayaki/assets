<?php
namespace Assets\Controller\Admin;

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
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $assets = $this->paginate($this->loadModel(), [
            'order' => [
                $this->loadModel()->getAlias() . '.created' => 'desc'
            ]
        ]);

        $this->set(compact('assets'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setTemplate('form');

        $asset = $this->loadModel()->newEntity();
        if ($this->request->is('post')) {
            $asset = $this->loadModel()->patchEntity($asset, $this->request->getData());
            if ($this->loadModel()->save($asset)) {
                $this->Flash->success(__d('localized', 'The {0} has been saved.', [__d('localized', 'file')]));

                // TODO
                return $this->redirect($this->_getRedirectUrl($this));
            }
            $this->Flash->error(__d('localized', 'The {0} could not be saved. Please, try again.', [__d('localized', 'file')]));
        }
        $this->set(compact('asset'));
    }

    /**
     * Edit method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function edit($id = null)
    {
        $this->viewBuilder()->setTemplate('form');

        $asset = $this->loadModel()->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $asset = $this->loadModel()->patchEntity($asset, $this->request->getData());
            if ($this->loadModel()->save($asset)) {
                $this->Flash->success(__d('localized', 'The {0} has been saved.', [__d('localized', 'file')]));

                // TODO
                return $this->redirect($this->_getRedirectUrl($this));
            }
            $this->Flash->error(__d('localized', 'The {0} could not be saved. Please, try again.', [__d('localized', 'file')]));
        }
        $this->set(compact('asset'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Asset id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $asset = $this->loadModel()->get($id);
        if ($this->loadModel()->delete($asset)) {
            $this->Flash->success(__d('localized', 'The {0} has been deleted.', [__d('localized', 'file')]));
        } else {
            $this->Flash->error(__d('localized', 'The {0} could not be deleted. Please, try again.', [__d('localized', 'file')]));
        }

        // TODO
        return $this->redirect($this->referer(
            $this->_getRedirectUrl($this)
        ));
    }

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

    /**
     * TODO
     * @param \Cake\Controller\Controller $controller
     * @return array
     */
    protected function _getRedirectUrl(Controller $controller)
    {
        return ['action' => 'index'];
    }
}
