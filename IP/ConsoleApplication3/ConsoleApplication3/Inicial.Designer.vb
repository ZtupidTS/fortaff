<Global.Microsoft.VisualBasic.CompilerServices.DesignerGenerated()> _
Partial Class Inicial
    Inherits System.Windows.Forms.Form

    'Form overrides dispose to clean up the component list.
    <System.Diagnostics.DebuggerNonUserCode()> _
    Protected Overrides Sub Dispose(ByVal disposing As Boolean)
        Try
            If disposing AndAlso components IsNot Nothing Then
                components.Dispose()
            End If
        Finally
            MyBase.Dispose(disposing)
        End Try
    End Sub

    'Required by the Windows Form Designer
    Private components As System.ComponentModel.IContainer

    'NOTE: The following procedure is required by the Windows Form Designer
    'It can be modified using the Windows Form Designer.  
    'Do not modify it using the code editor.
    <System.Diagnostics.DebuggerStepThrough()> _
    Private Sub InitializeComponent()
        Me.BtnImportArticle = New System.Windows.Forms.Button()
        Me.BtnSupplier = New System.Windows.Forms.Button()
        Me.SuspendLayout()
        '
        'BtnImportArticle
        '
        Me.BtnImportArticle.Location = New System.Drawing.Point(51, 35)
        Me.BtnImportArticle.Name = "BtnImportArticle"
        Me.BtnImportArticle.Size = New System.Drawing.Size(196, 23)
        Me.BtnImportArticle.TabIndex = 0
        Me.BtnImportArticle.Text = "Criar Artigos"
        Me.BtnImportArticle.UseVisualStyleBackColor = True
        '
        'BtnSupplier
        '
        Me.BtnSupplier.Location = New System.Drawing.Point(51, 64)
        Me.BtnSupplier.Name = "BtnSupplier"
        Me.BtnSupplier.Size = New System.Drawing.Size(196, 23)
        Me.BtnSupplier.TabIndex = 1
        Me.BtnSupplier.Text = "Alterações Fornecedor"
        Me.BtnSupplier.UseVisualStyleBackColor = True
        Me.BtnSupplier.UseWaitCursor = True
        '
        'Inicial
        '
        Me.AutoScaleDimensions = New System.Drawing.SizeF(6.0!, 13.0!)
        Me.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font
        Me.ClientSize = New System.Drawing.Size(292, 266)
        Me.Controls.Add(Me.BtnSupplier)
        Me.Controls.Add(Me.BtnImportArticle)
        Me.Name = "Inicial"
        Me.Text = "Inicial"
        Me.ResumeLayout(False)

    End Sub
    Friend WithEvents BtnImportArticle As System.Windows.Forms.Button
    Friend WithEvents BtnSupplier As System.Windows.Forms.Button
End Class
