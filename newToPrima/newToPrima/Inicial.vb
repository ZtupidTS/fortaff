Public Class Inicial

    Private Sub BtnImportArticle_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnImportArticle.Click
        Dim createart As ChooseFile
        createart = New ChooseFile()
        createart.Show()
    End Sub

    
    Private Sub BtnSupplier_Click(ByVal sender As System.Object, ByVal e As System.EventArgs) Handles BtnSupplier.Click
        Dim sup As ChangeSupplier
        sup = New ChangeSupplier()
        sup.Show()
    End Sub
End Class