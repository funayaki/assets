<?php
namespace Attachments\Controller\Admin;

use Attachments\Controller\AppController;

/**
 * Attachments Controller
 *
 * @property \Attachments\Model\Table\AttachmentsTable $Attachments
 *
 * @method \Attachments\Model\Entity\Attachment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AttachmentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $attachments = $this->paginate($this->Attachments);

        $this->set(compact('attachments'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $attachment = $this->Attachments->newEntity();
        if ($this->request->is('post')) {
            $attachment = $this->Attachments->patchEntity($attachment, $this->request->getData());
            if ($this->Attachments->save($attachment)) {
                $this->Flash->success(__('The attachment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The attachment could not be saved. Please, try again.'));
        }
        $this->set(compact('attachment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Attachment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $attachment = $this->Attachments->get($id);
        if ($this->Attachments->delete($attachment)) {
            $this->Flash->success(__('The attachment has been deleted.'));
        } else {
            $this->Flash->error(__('The attachment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
